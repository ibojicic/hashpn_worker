<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:47 PM
 */
namespace HashPN\App\Fetchers;

use HashPN\App\Common\qObject;
use HashPN\App\Common\Survey;
use MyPHP\MyArrays;
use MyPHP\MyFunctions as MyFunctions;
use MyPHP\MyLogger;
use MyPHP\MyPythons;
use MyPHP\MyStandards;
use Symfony\Component\Stopwatch\Stopwatch;

class Slicer
{
    use MyStandards;
    use MyPythons;

    private $_survey;
    private $_qobject;

    public $mylogger;

    public $stopwatch;


    public function __construct(Survey $_survey, qObject $_qobject)
    {
        //** assigned to dummy logger by default */
        $this->mylogger = new MyLogger(false);
        //$this->stopwatch = new Stopwatch();

        $this->_survey = $_survey;
        $this->_qobject = $_qobject;
    }

    public function setMyLogger(MyLogger $myLogger)
    {
        unset($this->mylogger);
        $this->mylogger = $myLogger;
    }

    public function sliceFields($cutoutsize, $bands)
    {
        $this->mylogger->logMessage("Start slicing." ,$this,"info");

        //make out folder
        $outPath = $this->getOutFolderFITS($this->_qobject->getIdPNmain(), $this->_survey->getSurveyParams('folder'));
        if (!is_dir($outPath)) {
            if (!mkdir($outPath)) {
                die("FATAL ERROR: Cannot create fits out folder: $outPath \n");
            }
        }

        $finalArray = array(
            'survey' => $this->_survey->getSurveyParams('set'),
            "idPNMain" => $this->_qobject->getIdPNmain(),
            "MajDiam" => $this->_qobject->getMajDiam(),
            "epoch" => $this->_survey->getSurveyParams('epoch'),
            "minval" => floatval($this->_survey->getSurveyParams('minval')),
            "maxval" => floatval($this->_survey->getSurveyParams('maxval')),
            "used_RAJ2000" => floatval($this->_qobject->getPNMainTable()->DRAJ2000),
            "used_DECJ2000" => floatval($this->_qobject->getPNMainTable()->DDECJ2000),
            "cutter" => $this->_survey->getSurveyParams('cutter'),
            "multiple" => $this->_survey->getSurveyParams('multipleExt'),
            "fitsExt" => $this->_survey->getSurveyParams('fitsExt'),
            "imsize" => $cutoutsize,
            "compress" => $this->_survey->getSurveyParams('compress'),
            "fields" => [],
            "attempt" => 'y',
            "attempt_date" => date("Y-m-d H:i:s")
        );


        foreach ($bands as $band) {

            $bestfields = $this->_pickBestFields($band);

            if (empty($bestfields)) {
                continue;
            }

            $distance_input = [];

            foreach ($bestfields as $bf) {

                $distance_input[ $bf['file_name']] = [
                    'Xcoord1' => $bf[$this->_survey->getSurveyParams('Xsource')],
                    'Ycoord1' => $bf[$this->_survey->getSurveyParams('Ysource')],
                    'frame1' => $this->convertFrames($this->_survey->getSurveyParams('Xpix')),
                    'Xcoord2' => $this->_qobject->getPNMainTable()->{$this->_survey->getSurveyParams('Xcoord')},
                    'Ycoord2' => $this->_qobject->getPNMainTable()->{$this->_survey->getSurveyParams('Ycoord')},
                    'frame2' => $this->convertFrames($this->_survey->getSurveyParams('Ycoord'))
                ];
            }

            $distance_output = $this->getDistances($distance_input);

            foreach ($bestfields as $bf) {

                $distance = $distance_output[$bf['file_name']];

                $field = trim(str_ireplace(array(".fits.fzq", ".fitsq", ".fzq", ".fitq"), "",
                    $bf['file_name'] . "q"));

                $fitsname = $this->fitsName($this->_survey->getSurveyParams('set'), $field, $this->_qobject->getIdPNmain(), 1, $band);

                $founddata = array(
                    "field" => $field,
                    "band" => $band,
                    "inImage" => $this->_survey->getSurveyParams('source_folder') . $bf['file_name'],
                    "outImage" => $outPath . $fitsname,
                    "filename" => $fitsname,
                    "maxX" => $bf['NAXIS1'] - 1,
                    "maxY" => $bf['NAXIS2'] - 1,
                    "distance" => $distance,
                    "run"   => isset($bf['run']) ? $bf['run'] : -1,
                    "run_id"   => isset($bf['run_id']) ? $bf['run_id'] : null,
                );

                array_push($finalArray['fields'], $founddata);
            }
        }

        $python_slicer = MyFunctions::pathslash(PY_DRIVER_DIR) . "slicer_driver.py";

        $slicerresult = $this->PythonToPhp($python_slicer, $finalArray,'local',true);

        $slicedfields = $slicerresult['fields'];
        unset($slicerresult['fields']);

        $finalResult = [];
        foreach ($slicedfields as $fielddata) {
            array_push($finalResult, array_merge($slicerresult, $fielddata));
        }

        return $finalResult;
    }


    private function _pickBestFields($band)
    {
        $searchrad = $this->_survey->getSurveyParams('pixscale') . " * "
            . "SQRT(POW(`NAXIS1` * " . $this->_survey->getSurveyParams('Xincrease') . " ,2) + "
            . "     POW(`NAXIS2` * " . $this->_survey->getSurveyParams('Yincrease') . ",2)) * 0.6 "; // 0.6 is half size -> it should be 0.5 but just in case :)

        $centerX = "`" . $this->_survey->getSurveyParams('Xsource') . "`";
        $centerY = "`" . $this->_survey->getSurveyParams('Ysource') . "`";

        $distance = "`MainGPN`.`GPNspherDist_ib`($centerX,$centerY," . $this->_qobject->getPNMainTable()->{$this->_survey->getSurveyParams('Xcoord')} . "," .
            $this->_qobject->getPNMainTable()->{$this->_survey->getSurveyParams('Ycoord')} . ")";

        $sqlwhere = $distance . '<' . $searchrad;

        $sqlwhere .= " AND `band` = '" . $band . "'";

        $list = $this->_survey->getSurveyModel()
            ->whereRaw($sqlwhere)
            ->whereNotNull('band')
            ->get()
            ->toArray();

        $result = empty($list) ? [] : $list;

        $this->mylogger->logMessage("Found " . count($result) . " suitable fields for slicing in the band=$band.",$this,'info');

        return $result;
    }


    public function fillFields($inputfiles = [])
    {
        $this->mylogger->logMessage("Filling downloaded fields." ,$this,"info");

        $fieldspath = $this->_survey->getSurveyParams('source_folder');

        // scan the image folder
        if (empty($inputfiles)) {
            $files = array_diff(scandir($fieldspath), array('..', '.'));
            $updatefiles = MyArrays::compareArrayWithDB($this->_survey->getSurveyModel(),$files,'file_name');
            foreach ($updatefiles as $filename) {
                array_push($inputfiles, [
                    'file_name' => $filename,
                    'band' => 'null',
                    'obsid' => 'null',
                    'run'   => 'null',
                    'grade' => 'null'
                ]);
            }
            if (empty($updatefiles)) {
                return false;
            }
        }

        $params_array = array(
            'survey' => $this->_survey->getSurveyParams('set'),
            'fieldpath' => $fieldspath,
            'currband' => "null",
            'compress' => $this->_survey->getSurveyParams('compress'),
            'hdrfields' => explode(",", $this->_survey->getSurveyParams('hdrfields')),
            'fitsExt' => $this->_survey->getSurveyParams('fitsExt'),
            'bands' => $this->_survey->getSurveyParams('bands'),
            'bandfield' => $this->_survey->getSurveyParams('bandfield')
        );

        foreach ($inputfiles as $file) {
            $input_array = array_merge($params_array,$file);
            $python_filler = MyFunctions::pathslash(PY_DRIVER_DIR) . "field_filler_driver.py";
            $python_results = $this->PythonToPhp($python_filler, $input_array,'local',True);
            $results = array_merge($input_array,$python_results);
            if ($results and $results !== null) {
                $this->_correctFields($this->_survey->getSurveyParams('set'), $this->_survey->getSurveyParams('bands'), $results);
                $results = array_intersect_key($results, array_flip($this->_survey->getSurveyModel()->getFillable()));
                $this->_survey->getSurveyModel()->insert($results);
            }
        }

        return true;
    }

    /**
     * @return mixed array of file names recorded in ImagesSources.survey
     */
    public function getRecordedFields()
    {
        return $this->_survey->getSurveyModel()->select('file_name')->pluck('file_name')->toArray();
    }


    /**
     * @param $surveyName string name of the survey
     * @param $bands array bands
     * @param $results array of results from the field filler python script
     * @return bool False on error
     */
    private function _correctFields($surveyName, $bands, &$results)
    {
        //convert "null" to NULL
        array_walk($results, function (&$item) {
            if ($item === "null") {
                $item = null;
            }
        });
        //add band name to the band field
        $bandMapping = array_flip($bands);

        if (isset($bandMapping[$results['band']])) {
            $results['band'] = $bandMapping[$results['band']];
        }

        //apply corrections specific to survey
        // TODO this goes into configuration
        switch ($surveyName) {
            case 'iphas':
                $results['IRAF-TLM']    = date("Y-m-d H:i:s",strtotime(str_ireplace("T", " ", $results['IRAF-TLM'])));
                $results['DATE']        = date("Y-m-d H:i:s",strtotime(str_ireplace("T", " ", $results['DATE'])));
                $results['DATE-OBS']    = date("Y-m-d H:i:s",strtotime(str_ireplace("T", " ", $results['DATE'])));
                $results['qcgrade']     = $results['grade'];
                break;
        }

        return true;
    }





}