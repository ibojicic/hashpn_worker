<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;

use MyPHP\MyFunctions;

class fetchWISE extends Fetcher implements FetchersInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchit()
    {
        $bands = [];

        $search = $this->cutoutSize / 3600; // search within

        $query = MyFunctions::getSiapQuery(
            $this->survey->getSurveyParams('siapURL'),
            $this->qobject->getPNMainTable()->DRAJ2000,
            $this->qobject->getPNMainTable()->DDECJ2000,
            $search,
            ['mcen' => '', 'INTERSECT' => 'CENTER']);

        $results = $this->getSiapResults($query, $this->survey->getSurveyParams('siapFields'));

        if (!$results || $results['pass'] != 'ok') {
            return $this->mylogger->logMessage($results['error'],$this,'critical',false);
        }

        foreach ($results['results'] as $line) {

            $band = $line[$this->survey->getSurveyParams('siapFields')->band];

            $this->mylogger->logMessage("Found band: ".$band,$this,'info');

            if (isset($band) && in_array($band, $this->survey->getSurveyParams('bands'))) {
                $band = array_flip($this->survey->getSurveyParams('bands'))[$band];

                @$imlink = $line[$this->survey->getSurveyParams('siapFields')->downlink];
                $imslice = $imlink . "?center=" . $this->qobject->getPNMainTable()->DRAJ2000 .
                    "," . $this->qobject->getPNMainTable()->DDECJ2000 . "deg&size=" . $search . "deg&gzip=false";


                $file_name = $this->fitsName($this->survey->getSurveyParams('set'), "",
                    $this->qobject->getIdPNmain(), 1, $band);

                $this->mylogger->logMessage("Downloading slice from:".$imslice,$this,'info');
                try {
                    system("wget -O " . $this->outPath . $file_name . " '" . $imslice . "'");
                } catch (\Exception $e) {
                    $this->mylogger->logMessage("Problem with downloading, thrown: " . $e->getMessage() ,$this,'error');
                    continue;
                }

                if (is_file($this->outPath . $file_name)) {
                    $this->mylogger->logMessage("Downloading ok.",$this,'info');
                    array_push($bands, [
                        'band' => $band,
                        'filename' => $file_name,
                        'out_file' => $this->outPath . $file_name
                    ]);
                }
            }
        }

        $fetchedfields = [
            'idPNMain' => $this->qobject->getIdPNmain(),
            //'survey_name' => $this->survey->getSurveyParams('montageName'),
            'used_RAJ2000' => $this->qobject->getPNMainTable()->DRAJ2000,
            'used_DECJ2000' => $this->qobject->getPNMainTable()->DDECJ2000,
            'XcutSize' => $this->cutoutSize,
            'YcutSize' => $this->cutoutSize,
            'bands' => $bands,
            'attempt' => 'y'

        ];

        return MyFunctions::flattenArray($fetchedfields, 'bands');
    }


}