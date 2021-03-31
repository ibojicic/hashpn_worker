<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 3/2/2017
 * Time: 2:15 PM
 */

use HashPN\App\Common\Survey;
use MyPHP\MyArrays as MyArrays;

define('MODEL_NAMESPACE','HashPN');

require '../vendor/autoload.php';
require "../config/bootEloquent.php";

$testingobjects = [
    'galex'         => 10935, //fields
    'vvve'          => 14958, //fields
    'ukidss'        => 14958, //fields
    'glimpse_full'  => 14958,
    'nvss'  => 14958,
    'mips24'  => 14958,
    'shassa'  => 14958,
    'mips70'  => 8255,
    'vtss'  => 10935,
    'mgps2'  => 18060,
    'spitzer_target'    => 5773,
    'lmc_mcels' => 17184,
    'sage_irac' => 17184,
    'shs_mc' => 17184,
    'popiplan_eso' => 12937,
    'radiomash' => 5775,
    'cornish'   => 22974,
    'iphas' => 23318, //fields
    '2mass' => 23318,
    'sdss'  => 18055,
    'shs' => 12997,
    'wise' => 12997,
    'sss' => 12997,
    'gps'   => 22946,
    'quot_HaSr'   => 22946,
    'iquot_HaSr'   => 23318,

];

$path = "test_container/test_fetch/";

$testaction = $argv[1];
$testsurvey = $argv[2];

if ($testsurvey == 'all') {
    $testsurvey = $testingobjects;
} else {
    $testsurvey = [$testsurvey => $testingobjects[$testsurvey]];
}


$config = new \MyPHP\MyConfig();

$final_result = [];
$res_format = "Diff: for key %s original> %s<>%s <collected";


foreach ($testsurvey as $current_survey => $id) {
    $survey = new Survey($current_survey);

    if ($testaction == 'collect') {
        $file = $path . $current_survey . "_test.log";
        $collected = collectData($survey, $id);
        $jsoned = json_encode($collected);
        file_put_contents($file, $jsoned);
    } elseif ($testaction = 'test') {
        system("hashpn fetch " . $current_survey . " " . $id . " -w force -vvv");
        $collected = collectData($survey, $id);
        $file = $path . $current_survey . "_test.log";
        $original = json_decode(file_get_contents($file), true);

        $final_result[$current_survey] = [];
        if ($original == $collected) {
            array_push($final_result[$current_survey],"Everything is nice and smooth!!\n");
        } else {
            echo "I've found some inconsistencies....\n";

            foreach ($original as $file => $data) {
                echo $file . "\n";
                if (!isset($collected[$file])) {
                    die ("File " . $file . " is not collected....");
                }

                foreach ($data as $key => $val) {
                    if ($val !== $collected[$file][$key]) {
                        $result = sprintf($res_format, $key, $val, $collected[$file][$key]);
                        array_push($final_result[$current_survey], $result);
                    }
                }
            }
        }

    } else {
        die('wrong test action: collect/test');
    }

}

dd($final_result);

function getResultData(Survey $survey, $id)
{
    $bands = array_keys($survey->getSurveyParams('bands'));
    return $survey->getResultsModel()->where('idPNMain', $id)->whereIn('band',$bands)->get()->toArray();
}

function checkMadeImages(Survey $survey, $id)
{
    $outPath = $survey->getOutFolderFITS($id, $survey->getSurveyParams('folder'));
    $list = glob($outPath . "*");
    return $list;
}

function collectData(Survey $survey, $id)
{
    $resultData = getResultData($survey,$id);
    $tmpresultData = $resultData;
    foreach ($tmpresultData as $key => $data) {
        $outPath = $survey->getOutFolderFITS($id, $survey->getSurveyParams('folder'));
        if ($data['found'] == 'y' && is_file($outPath . $data['filename'])) {
            unset($resultData[$key]["id" . $survey->getSurveyParams('set')],$resultData[$key]['attempt_date'],$resultData[$key]['created_at'],$resultData[$key]['updated_at']);
            $resultData[$key]['filesize'] = filesize($outPath . $data['filename']);
        } else {
            unset($resultData[$key]);
        }
    }
    $result = MyArrays::changeKeyArray($resultData,'filename');
    return $result;
}