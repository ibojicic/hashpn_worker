<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;

use MyPHP\MyFunctions;

class fetchMONTAGE extends Fetcher implements FetchersInterface
{

    public function __construct()
    {
        parent::__construct();
    }


    public function fetchit()
    {
        $bands = [];

        foreach ($this->bandsToFetch as $band) {
            if (!in_array($band,$this->bandsToFetch)) {
                continue;
            }
            $file_name = $this->fitsName($this->survey->getSurveyParams('set'), "",
                $this->qobject->getIdPNmain(), 1, $band);
            array_push($bands, [
                'band' => $this->survey->getSurveyParams('bands')[$band],
                'filename' => $file_name,
                'out_file' => $this->outPath . $file_name,
            ]);
        }

        $input_array = [
            'idPNMain' => $this->qobject->getIdPNmain(),
            'survey_name' => $this->survey->getSurveyParams('montageName'),
            'used_RAJ2000' => $this->qobject->getPNMainTable()->DRAJ2000,
            'used_DECJ2000' => $this->qobject->getPNMainTable()->DDECJ2000,
            'cutoutsize' => $this->cutoutSize / 3600,
            'bands' => $bands,
            'attempt' => 'y'

        ];

        $python_filler = MyFunctions::pathslash(PY_DRIVER_DIR) . "montage_postage_stamps_driver.py";
        $python_results = $this->PythonToPhp($python_filler, $input_array,'local',true);

        return MyFunctions::flattenArray($python_results, 'bands');
    }



}