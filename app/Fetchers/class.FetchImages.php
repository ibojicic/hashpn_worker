<?php
namespace HashPN\App\Fetchers;

use HashPN\App\Common\qObject;
use HashPN\App\Common\Survey;
use HashPN\App\Fetchers;
use MyPHP\MyConfig;
use MyPHP\MyFunctions;
use MyPHP\MyLogger;
use MyPHP\MyPythons;
use MyPHP\MyStandards;

/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 6/1/2017
 * Time: 2:08 PM
 */
class FetchImages
{
    use MyStandards;
    use MyPythons;

    /**
     * @var Survey $_survey
     */
    private $_survey;

    /**
     * @var qObject $_qobject
     */
    private $_qobject;

    /**
     * @var Fetchers\fetchMosaics
     */
    public $fetcher;

    /**
     * @var MyConfig
     */
    public $config;

    /**
     * @var MyLogger
     */
    public $mylogger;


    public $okflag = true;

    public function __construct(Survey $survey, qObject $qobject, MyConfig $myConfig)
    {
        $this->config = $myConfig;
        //** assigned to dummy logger by default */
        $this->mylogger = new MyLogger(false);

        $this->_survey = $survey;
        $this->_qobject = $qobject;
    }

    public function setMyLogger(MyLogger $myLogger)
    {
        unset($this->mylogger);
        $this->mylogger = $myLogger;
    }

    /**
     * Get a fetcher class from the table name (db:ImagesSources)
     * with assigning initial parameters Survey $survey and qObject $object
     * @param $table string table (model) name
     * @return mixed object
     */
    private function _getFetcherFromName($table)
    {
        $namespace = MODEL_NAMESPACE . "\\App\\Fetchers\\" . $table;
        return new $namespace();
    }


    /**
     * Set fetcher object from survey & id parameters
     * @param $rewrite string select from force:redo:new see command.fetchimage
     */
    public function attachFetcher($rewrite)
    {
        //** set fetcher object */
        $this->fetcher = $this->_getFetcherFromName($this->_survey->getSurveyParams('fetcher'));

        //** set survey & object for the fetcher */
        $this->fetcher->setSurvey($this->_survey);
        $this->fetcher->setQobject($this->_qobject);
        $this->fetcher->setMyLogger($this->mylogger);

        //** set extra models needed by fetcher */
        if (!empty($this->fetcher->extraModels)) {
            foreach ($this->fetcher->extraModels as $name => $data) {
                $modelname = $this->getModelFromName(MODEL_NAMESPACE, $data['DB'], $data['table']);
                $this->fetcher->{$name} = new $modelname;
            }
        }

        //****************************************************/
        //** set cutout size for the current survey & object */
        $cutoutSize = $this->getCutoutSize(
            max($this->_qobject->getMajDiam(), $this->_qobject->getMajExt()),
            $this->_survey->getSurveyParams('minimDiam'),
            false,
            'y',
            $this->_survey->getSurveyParams('maxDiam'));
        echo "-".$cutoutSize."-\n";

        if (!is_numeric($cutoutSize) || $cutoutSize <= 0 || $cutoutSize > MAX_CUTOUT_SIZE) {
            $this->mylogger->logMessage("Cutout size of ".$cutoutSize." is not allowed!",$this,'warning');
            $cutoutSize = MAX_CUTOUT_SIZE;
        }
        echo "Max cutout size:\n";
        echo MAX_CUTOUT_SIZE."\n";
        exit();
        $this->fetcher->setCutoutSize($cutoutSize);
        $this->mylogger->logMessage("Set cutout size of ".$cutoutSize.".",$this,'info');
        //****************************************************/

        //****************************************************/
        //** set bands to be fetched */
        $bandsToFetch = $this->_getBandsToFetch($rewrite);
        if ($bandsToFetch) {
            $this->mylogger->logMessage("Set bands to be fetched: ".implode(',',$bandsToFetch),$this,'info');
            $this->fetcher->setBandsToFetch($bandsToFetch);
        }
        //****************************************************/

        //** set out path for the fetcher */
        $this->fetcher->outPath = $this->getOutFolderFITS($this->_qobject->getIdPNMain(),$this->_survey->getSurveyParams('folder'),true);
//        if (!is_dir($this->fetcher->outPath)) {
//            mkdir($this->fetcher->outPath,0777,true);
//        }

        $this->fetcher->setSlicer(new Slicer($this->_survey,$this->_qobject));

    }


    /**
     * get bands to be fetched
     * @param string $rewrite string force:redo:new see command.fetchimage
     * @return array
     */
    private function _getBandsToFetch($rewrite = 'new')
    {
        $bands = [];
        if ($rewrite == 'redo') {
            $bands = $this->_getMissingBands();
        } elseif ($rewrite == 'force') {
            $bands = array_keys((array)$this->_survey->getSurveyParams('bands'));
        } elseif ($rewrite == 'new') {
            if (!$this->objectIsNew()) {
                $this->mylogger->logMessage("Object is already fully fetched. To re-check missing bands use option '-w redo', to re-fetch images use '-w force'.",
                    $this, 'warning');
            }
        }
        if (empty($bands)) {
            $this->mylogger->logMessage("No bands to process for object.", $this, 'warning');
            $this->okflag = false;
        }
        return $bands;
    }


    /**
     * check which bands are missing for specific id & survey
     * @return array of missing bands
     */
    private function _getMissingBands()
    {
        $existingbands = array_keys((array)$this->_survey->getSurveyParams('bands'));

        $foundbandds = $this->getResults()
            ->where('found', 'y')
            ->groupBy('band')
            ->pluck('band')
            ->toArray();

        return array_diff($existingbands, $foundbandds);
    }

    /**
     * @return bool true if object doesn't have any inputs in results model table
     */
    public function objectIsNew()
    {
        return ($this->getResults()
                ->first() == null);
    }

    /**
     * Delete old files and db entries
     * @return number of delete objects
     */
    public function deleteOldResults($newresults)
    {
        $oldFiles = $this->getResults()
            ->whereIn('band', $this->fetcher->getBandsToFetch())
            ->pluck('filename')
            ->toArray();

        $newFiles = array_column($newresults,'filename');

        $this->mylogger->logMessage("Deleting old files....",$this,'info');
        foreach ($oldFiles as $file) {
            $file_path = MyFunctions::pathslash($this->fetcher->outPath) . $file;
            if (trim($file) != "" && trim($file) != "*" && is_file($file_path) && !in_array($file,$newFiles)) {
                unlink($file_path);
            }
        }

        $this->mylogger->logMessage("Deleting old db entries....",$this,'info');
        $noDeleted = $this->getResults()
            ->whereIn('band', $this->fetcher->getBandsToFetch())
            ->delete();

        return $noDeleted;
    }

    /**
     * Record fetched results to the database
     * @param $results
     * @return bool True on success
     */
    public function recFetchingResultsToDB($results)
    {
        //** No results */
        if (empty($results)) {
            return $this->mylogger->logMessage('Empty inputs', $this, 'critical', false);
        }

        $noDeleted = $this->deleteOldResults($results);

        $noInserted = 0;
        foreach ($results as $result) {
            $founddata = array_intersect_key($result, array_flip($this->_survey->getResultsModel()->getFillable()));
            $inserted = $this->_survey
                ->getResultsModel()
                ->create($founddata);
            if ($inserted) {
                $noInserted++;
            }
        }

        $this->mylogger->logMessage("Deleted: $noDeleted, inserted: $noInserted", $this, 'info');
        return True;
    }


    public function setResultsInUse()
    {
        $noInUse = 0;
        foreach ($this->fetcher->getBandsToFetch() as $band) {
            //find minimum distance
            $minDist = $this->getResults()
                ->where('band', $band)
                ->where('found', 'y')
                ->orderBy('distance')
                ->first();
            //update minimum distance to 1
            if (!empty($minDist)) {
                $minDist->inuse = 1;
                if ($minDist->save()) {
                    $noInUse++;
                }
            }
        }
        $this->mylogger->logMessage("INFO: updated $noInUse to InUse.", $this, 'info');
    }


    public function getResults()
    {
        return $this->_survey
            ->getResultsModel()
            ->where('idPNMain', $this->_qobject->getIdPNMain());

    }




}