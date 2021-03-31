<?php
namespace HashPN\App\Common;

use HashPN\Models\PNImages\dummy_results;
use HashPN\Models\PNImages\Imagesets;
use MyPHP\MyLogger;
use MyPHP\MyPythons;
use MyPHP\MyStandards;

/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 6/1/2017
 * Time: 2:08 PM
 */
class Survey
{
    use MyStandards;
    use MyPythons;

    /**
     * @var Imagesets $_surveyParams
     */
    private $_surveyParams;

    /**
     * @var dummy_results $_resultsModel
     */
    private $_resultsModel;

    /**
     * @var MyLogger $mylogger
     */
    public $mylogger;


    /**
     * @var mixed $_surveyModel
     */
    private $_surveyModel;

    /**
     * array of possible extensions of fits files
     * @var array $possible_ext
     */
    public $possible_ext = [
        ".fits",
        ".fit",
        ".fts"
    ];

    /**
     * array of used extensions for the compression
     * @var array $compress_ext
     */
    public $compress_ext = [
        'gunzip' => 'gz',
        'funpack' => 'fz'
    ];

    public function __construct($set)
    {
        //** assigned to dummy logger by default */
        $this->mylogger = new MyLogger(false);

        $this->_setSurveyParams($set);

        $this->_setSurveyModel();

        $this->_setResultsModel();

    }

    public function setMyLogger(MyLogger $myLogger)
    {
        $this->mylogger = $myLogger;
    }


    /**
     * set data for a survey from the database
     * @param $set string name of the survey (column 'set')
     */
    private function _setSurveyParams($set)
    {
        $this->_surveyParams = Imagesets::where('set', $set)->first();

        $this->_surveyParams->bands = $this->_getBandMapping();

        $this->_surveyParams->siapFields = $this->_getSIAPFields();

    }

    /**
     * @return mixed array of bands ['band in db' => 'band in survey'] if parsable, False if not
     */
    private function _getBandMapping()
    {
        return json_decode($this->_surveyParams->bandsMap,true);
    }

    /**
     * @return boolean|\stdClass of SIAP fields
     */
    private function _getSIAPFields()
    {
        return json_decode($this->_surveyParams->siapFields);
    }

    /**
     * set Source survey model (model from a table with source files e.g. ImagesSources.IPHAS)
     * if not existent returns the DUMMY model.
     */
    private function _setSurveyModel()
    {
        $modelname = $this->getModelFromName(MODEL_NAMESPACE, "ImagesSources", $this->_surveyParams->model);
        if (!class_exists($modelname)) {
            $this->mylogger->logMessage("ImagesSources." . $this->_surveyParams->model . " was not found. Using 'DUMMY' instead.",$this,'info');
            $modelname = $this->getModelFromName(MODEL_NAMESPACE, "ImagesSources", "DUMMY");
        }
        $this->_surveyModel = new $modelname();
    }

    /**
     * set Results survey model (model from a table where results are stored e.g. PNImages.iphas)
     * on error die.
     */
    private function _setResultsModel()
    {
        $modelname = $this->getModelFromName(MODEL_NAMESPACE, "PNImages", $this->_surveyParams->resultsmodel);
        if (!class_exists($modelname)) {
            $this->mylogger->logMessage("PNImages." . $this->_surveyParams->resultsmodel . " was not found.",$this,'error');
        }
        $this->_resultsModel = new $modelname();
    }


    /**
     * Returns values from imagesets table for the set survey
     * @param bool|string $parameter to be returned, if False return the whole model
     * @return mixed
     */
    public function getSurveyParams($parameter = False)
    {
        if (!$parameter) {
            return $this->_surveyParams;
        }
        if ($this->_surveyParams->{$parameter} === null) {
            die(__METHOD__ . ":Parameter $parameter do not exists.\n");
        }
        return $this->_surveyParams->{$parameter};

    }

    /**
     * @return mixed
     */
    public function getSurveyModel()
    {
        return $this->_surveyModel;
    }

    /**
     * @return mixed
     */
    public function getResultsModel()
    {
        return $this->_resultsModel;
    }



}