<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;

use HashPN\Models\PNImages\Imagesets;
use MyPHP\MyFunctions;

class fetchFitsFunc extends Fetcher implements FetchersInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function fetchit()
    {

        $fitsfunc = $this->survey->getSurveyParams('fetchfitsfunc');

        $commands = $this->{$fitsfunc}();

        if (!$commands) {
            return $this->mylogger->logMessage("No results.", $this, "warning", false);
        }

        $python_driver = MyFunctions::pathslash(PY_DRIVER_DIR) . "fits_func_driver.py";

        $tmpcommand = $commands;


        foreach ($tmpcommand as $key => $comm) {
            $results = $this->PythonToPhp($python_driver, $comm["functions"],'local', true);
            if ($results['pass'] == 'nok') {
                $this->mylogger->logMessage("Error in applying function:".
                    json_encode($comm['functions'])." => ".$results['error'],$this,'warning');
            }
        }

        $fetchedfields = [
            'idPNMain' => $this->qobject->getIdPNMain(),
            'survey_name' => $this->survey->getSurveyParams('set'),
            'used_RAJ2000' => $this->qobject->getPNMainTable()->DRAJ2000,
            'used_DECJ2000' => $this->qobject->getPNMainTable()->DDECJ2000,
            'XcutSize' => $this->cutoutSize,
            'YcutSize' => $this->cutoutSize,
            'bands' => $commands,
            'attempt' => 'y'

        ];

        return MyFunctions::flattenArray($fetchedfields, 'bands');
    }


    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function _setQoutPars()
    {
        $result = [];

        $quotpair = json_decode($this->survey->getSurveyParams('quotpair'), true);

        $outPath_dvd = MyFunctions::pathslash(
            $this->getOutFolderFITS(
                $this->qobject->getIdPNMain(),
                Imagesets::where('set', $quotpair['dvd']['set'])
                    ->pluck('folder')
                    ->first()
            )
        );

        $outPath_dvs = MyFunctions::pathslash(
            $this->getOutFolderFITS(
                $this->qobject->getIdPNMain(),
                Imagesets::where('set', $quotpair['dvs']['set'])
                    ->pluck('folder')
                    ->first()

            )
        );

        $runids = $this->_getRunIds($quotpair['dvd']['set']);

        foreach ($runids as $run_value) {

            $run_id = $run_value['run_id'];


            $out_name = $this->fitsName($this->survey->getSurveyParams('set'), $run_id,
                $this->qobject->getIdPNMain(), 1, $this->bandsToFetch[0]);

            $out_image = $this->outPath . $out_name;

            $dvd = $this->_getFitsFile($quotpair['dvd']['set'], $quotpair['dvd']['band'], $run_id);
            $dvs = $this->_getFitsFile($quotpair['dvs']['set'], $quotpair['dvs']['band'], $run_id);

            if (!is_file($outPath_dvd . $dvd) || !is_file($outPath_dvs . $dvs)) {
                continue;
            }

            $format = "quotientImage('%s','%s','%s')";
            $command = sprintf($format, $outPath_dvd . $dvd, $outPath_dvs . $dvs, $out_image);

            array_push($result, [

                'functions' => [$command],
                'filename' => $out_name,
                'image' => $out_image,
                'band' => $this->bandsToFetch[0],
                'run_id' => $run_id,
                'field' => -1,
                'inuse' => 0,

            ]);
        }

        return $result;
    }

    private function _getRunIds($setname)
    {
        $result = $this->qobject->getPNMainTable()->{$setname}()
            ->where('found', 'y')
            ->distinct('run_id')
            ->get(['run_id'])
            ->toArray();

        return $result;
    }

    private function _getFitsFile($setname, $band, $run_id)
    {
        $file = $this->qobject->getPNMainTable()->{$setname}()
            ->where('found', 'y')
            ->where('band', $band)
            ->where('run_id', $run_id)
            ->pluck('filename')
            ->first();
        return $file;
    }


}