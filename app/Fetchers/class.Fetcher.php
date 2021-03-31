<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;

use HashPN\App\Common\qObject;
use HashPN\App\Common\Survey;
use MyPHP\MyFunctions;
use MyPHP\MyLogger;
use MyPHP\MyPythons;
use MyPHP\MyStandards;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as RV;

class Fetcher implements FetchersInterface
{
    use MyPythons;
    use MyStandards;

    /**
     * @var Survey $survey
     */
    protected $survey;

    /**
     * @var qObject $qobject
     */
    protected $qobject;

    /**
     * @var Slicer $slicer
     */
    public $slicer;

    /**
     * @var MyLogger $mylogger
     */
    protected $mylogger;

    /**
     * @var bool|float $cutoutSize
     */
    protected $cutoutSize = false;

    /**
     * @var bool|array $bandsToFetch
     */
    protected $bandsToFetch = false;

    /**
     * @var array $extraModels
     */
    public $extraModels = [];

    /**
     * @var array $_results
     */
    protected $_results = [];



    /**
     * @var bool|string
     */
    public $outPath = false;


    public function __construct()
    {
        //** assigned to dummy logger by default */
        $this->mylogger = new MyLogger(false);
    }

    public function setMyLogger(MyLogger $myLogger)
    {
        unset($this->mylogger);
        $this->mylogger = $myLogger;
    }

    public function requireExtraModel($name, $DB, $table)
    {
        $this->extraModels[$name] = [
            'DB' => $DB,
            'table' => $table
        ];

    }

    public function fetchit()
    {
        return false;
    }

    public function getresults()
    {
        return $this->_results;
    }

    /**
     * @param array $results
     * @return bool false on error
     */
    public function setResults($results)
    {
        //** set found = y if file exists */
        $results = $this->_setFound($results);
        /*******************************/
        //** validate results if nok die*/
        $validate = $this->_validateResults($results);
        if (!empty($validate)) {
            return $this->mylogger->logMessage("Problem with results from the fetcher:" . json_encode($validate),$this,'error',false);
        }
        /*******************************/

        $this->_results = $results;
    }

    /**
     * check if all files in the results (field 'filename') do exist
     * @param $results array input array from the fetcher
     * @return mixed
     */
    private function _setFound($results)
    {
        $tmpresults = $results;
        foreach ($tmpresults as $reskey => $result) {
            $results[$reskey]['found'] = 'n';
            if (isset($result['filename'])) {
                if (is_file(MyFunctions::pathslash($this->outPath) . $result['filename'])) {
                    $results[$reskey]['found'] = 'y';
                } else {
                    unset($results[$reskey]['filename']);
                }
            }
        }
        return $results;
    }

    /**
     * @param $size float size (in declination) in arcsec of the final cutout
     */
    public function setCutoutSize($size)
    {
        $this->cutoutSize = $size;
    }

    /**
     * @param mixed $bandsToFetch
     */
    public function setBandsToFetch($bandsToFetch)
    {
        $this->bandsToFetch = $bandsToFetch;
    }

    /**
     * @return mixed
     */
    public function getBandsToFetch()
    {
        return $this->bandsToFetch;
    }

    /**
     * @param Survey $survey
     */
    public function setSurvey(Survey $survey)
    {
        $this->survey = $survey;
    }

    /**
     * @param qObject $qobject
     */
    public function setQobject(qObject $qobject)
    {
        $this->qobject = $qobject;
    }

    /**
     * @param Slicer $slicer
     */
    public function setSlicer(Slicer $slicer)
    {
        $this->slicer = $slicer;
        $this->slicer->setMyLogger($this->mylogger);
    }

    /**
     * check if file exists
     * @param $file string path+file of the file to be checked
     * @param string $compress_ext string if compress extension of the compressed file (e.g. 'gz')
     * @return bool true if exists
     */
    protected function checkFileExists($file, $compress_ext = "")
    {
        if (is_file($file . $compress_ext) || is_file($file)) {
            return true;
        }
        return false;
    }

    /**
     * download file from url to target file
     * @param $download_file string path+name of the result file
     * @param $image_link string url of the file to be downloaded
     * @param string $compress_ext string if compress extension of the compressed file (e.g. 'gz')
     */
    protected function downloadFile($download_file, $image_link, $compress_ext = "")
    {
        try {
            system("wget --output-document=" . $download_file . $compress_ext . " '" . $image_link . "'");
        } catch (\Exception $e) {
            $this->mylogger->logMessage("Problem with downloading " . $image_link . "\nThrown: " . $e->getMessage(),
                $this, "info");
        }
        $this->checkFileExists($download_file, $compress_ext);
    }

    /**
     * Validates results from a fetcher
     * @param $results array of results from the fetcher [['used_RAJ2000' => 32.43,.....],['used_RAJ2000' => 43.32,....
     * @return array empty if everything ok or errors if nok
     */
    private function _validateResults($results)
    {
        $validation_results = [];
        /*******************************/
        //** test if input result is an array */
        try {
            RV::arrayVal()->assert($results);
        } catch (NestedValidationException $exception) {
            array_push($validation_results, $exception->getMessages());
            //**  on error get out */
            return $validation_results;
        }
        /*******************************/
        foreach ($results as $result) {


            /*******************************/
            //** test required fields */
            try {
                RV::key('used_RAJ2000', RV::floatVal())->assert($result);
                RV::key('used_DECJ2000', RV::floatVal())->assert($result);
                RV::key('band', RV::in($this->bandsToFetch))->assert($result);
                RV::key('found', RV::in(['y', 'n']))->assert($result);
            } catch (NestedValidationException $exception) {
                array_push($validation_results, $exception->getMessages());
            }
            /*******************************/

            /*******************************/
            //** test if file exists */
            $testfile = RV::key('filename', RV::stringType()->notEmpty())->validate($result);
            if ($testfile) {
                //$testfile_exists = RV::exists()->validate(new \SplFileInfo(MyFunctions::pathslash($this->outPath) . $result['filename']));
                //** if file exists it must have cut sizes */
                try {
                    RV::key('XcutSize', RV::floatVal())->assert($result);
                    RV::key('YcutSize', RV::floatVal())->assert($result);
                    RV::key('found', RV::equals('y'))->assert($result);
                } catch (NestedValidationException $exception) {
                    array_push($validation_results, $exception->getMessages());
                }
                /*******************************/
            }

            /*******************************/
            //** if field field is present it must have a distance from the center */
            /*
            $testfield = RV::key('field', RV::stringType())->validate($result);
            if ($testfield) {
                try {
                    RV::key('distance', RV::floatVal())->assert($result);
                } catch (NestedValidationException $exception) {
                    array_push($validation_results, $exception->getMessages());
                }
            }
            */
            /*******************************/
        }
        return $validation_results;
    }


}