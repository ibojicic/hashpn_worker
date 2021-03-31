<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;

use HashPN\Models\ImagesSources\IPHASFull;
use MyPHP\MyFunctions;

class fetchIPHAS extends Fetcher implements FetchersInterface
{
    /**
     * @var IPHASFull $IPHASFullModel
     */
    public $IPHASFullModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireExtraModel('IPHASFullModel', 'ImagesSources', 'IPHASFull');
    }


    public function fetchit()
    {

        foreach ($this->bandsToFetch as $band) {

            if (!in_array($band,$this->bandsToFetch)) {
                continue;
            }

            $findFieldsSQL = $this->qobject->getPNMainTable()->DRAJ2000 . " BETWEEN `ra_min` AND `ra_max` AND "
                . $this->qobject->getPNMainTable()->DDECJ2000 . " BETWEEN `dec_min` AND `dec_max` AND "
                . "`band` = '" . $band . "'";

            $bandresults = $this->IPHASFullModel->whereRaw($findFieldsSQL)->get()->toArray();

            if (!$bandresults) {
                $this->mylogger->logMessage("No results for band $band.",$this,"warning");
                continue;
            }

            foreach ($bandresults as $banddata) {
                $imlink = $banddata['url'];
                $run = $banddata['run'];
                $qcgrade = $banddata['qcgrade'];
                $fileinbase = $banddata['file_name'];
                $run_id = $banddata['run_id'];

                $imfile = MyFunctions::pathslash($this->survey->getSurveyParams('source_folder')) . $fileinbase;

                if ($this->survey->getSurveyModel()->where('file_name', $fileinbase)->count() == 0) {
                    if (!is_file($imfile)) {
                        $this->mylogger->logMessage("Downloading file:" . $imlink ,$this,"info");
                        system("wget --output-document=" . $imfile . " '" . $imlink . "'");
                    }
                    //check after wget
                    if (is_file($imfile)) {
                        $fechedfields = [
                            'band' => $band,
                            'run' => $run,
                            'file_name' => $fileinbase,
                            'grade' => $qcgrade,
                            'run_id' => $run_id
                        ];
                        if (!$this->slicer->fillFields([$fechedfields])) {
                            $this->mylogger->logMessage("Problem with recording fetched fields:". json_encode($fechedfields), $this, "warning");
                        }
                    }
                }
            }
        }

        $this->mylogger->logMessage("Slicing files." ,$this,"info");

        return $this->slicer->sliceFields($this->cutoutSize, $this->bandsToFetch);

    }




}