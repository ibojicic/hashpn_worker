<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 21/1/2017
 * Time: 8:55 PM
 */
namespace HashPN\App\Fetchers;

use HashPN\App\Common\qObject;
use HashPN\App\Common\Survey;
use MyPHP\MyLogger;

interface FetchersInterface
{
    public function fetchit();

    public function requireExtraModel($name, $DB, $table);

    public function getresults();

    public function setresults($results);

    public function setMyLogger(MyLogger $mylogger);

    public function setCutoutSize($size);

    public function setBandsToFetch($bands);

    public function getBandsToFetch();

    public function setSurvey(Survey $survey);

    public function setQobject(qObject $qobject);

    public function setSlicer(Slicer $slicer);

}