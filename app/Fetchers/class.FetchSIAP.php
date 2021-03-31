<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;

use MyPHP\MyFunctions;

class fetchSIAP extends Fetcher implements FetchersInterface
{

    private $_fetchedfields = [];

    public function __construct()
    {
        parent::__construct();
    }

     public function fetchit()
    {
        $SIAPquery = MyFunctions::getSiapQuery(
            $this->survey->getSurveyParams('siapURL'),
            $this->qobject->getPNMainTable()->DRAJ2000,
            $this->qobject->getPNMainTable()->DDECJ2000,
//            this one looks for mosaics within cutout size
//            which could be ok if the mosaics are stitched together later on
//            however, that's not realistic for large objects or small mosaics
//            $this->cutoutSize / 3600,
//            so switch to looking within size of mosaics (PNImages.imagesets.search_radii)
            $this->survey->getSurveyParams('search_radii'),
            (array)json_decode($this->survey->getSurveyParams('siap_extra'))
            );

        $this->mylogger->logMessage("Query string:" . $SIAPquery ,$this,"info");

        echo $SIAPquery;
        $SIAPresults = $this->getSiapResults($SIAPquery, $this->survey->getSurveyParams('siapFields'), false,
            $this->survey->getSurveyParams('correctXML'));

        if (!$SIAPresults || $SIAPresults['pass'] != 'ok') {
            return $this->mylogger->logMessage($SIAPresults['error'] ,$this,"critical",false);
        }

        $SIAPresultsExtracted = $this->_extractBands($SIAPresults['results']);

        if (empty($SIAPresultsExtracted)) {
            return $this->mylogger->logMessage("No results.",$this,"critical",false);
        }

        $this->mylogger->logMessage("Query results:" . json_encode($SIAPresultsExtracted) ,$this,"info");

        $unique_filenames = [];

        foreach ($SIAPresultsExtracted as $SIAPresult) {

            $obsid = "";
            $found_band = $SIAPresult[$this->survey->getSurveyParams('siapFields')->band];

            @$image_link = $SIAPresult[$this->survey->getSurveyParams('siapFields')->downlink];
            if (!isset($image_link) || !filter_var($image_link, FILTER_VALIDATE_URL)) {
                $this->mylogger->logMessage("Invalid image link: " . $image_link ,$this,"warning");
                continue;
            }

            if (isset($this->survey->getSurveyParams('siapFields')->obsid)) {
                @$obsid = $SIAPresult[$this->survey->getSurveyParams('siapFields')->obsid];
                if (!isset($obsid) || trim($obsid) == '') {
                    $this->mylogger->logMessage("Invalid obsid parameter: " . $image_link ,$this,"warning");
                    continue;
                }
            }

            $original_filename = basename($image_link);

            if (in_array($original_filename,$unique_filenames)) {
                continue;
            }

            array_push($unique_filenames,$original_filename);

            $obsid_ext = $obsid == "" ? "" : "_obsid" . $obsid;
            $compress_ext = "";

            if ($this->survey->getSurveyParams('decompress') != '0') {
                $compress_ext = "." . $this->survey->compress_ext[$this->survey->getSurveyParams('decompress')];
                $original_filename = trim(str_ireplace($compress_ext, "", $original_filename));
            }

            if (!stripos($original_filename, ".fits")) {
                $original_filename = trim(str_ireplace($this->survey->possible_ext, $obsid_ext . ".fits", $original_filename));
            }

            if ($original_filename == "" || strlen($original_filename) < 11) {
                $this->mylogger->logMessage("Problem with file name: " . $original_filename ,$this,"critical");
                continue;
            }

            $downlad_filename = MyFunctions::pathslash($this->survey->getSurveyParams('source_folder')) . $original_filename;

            $file_exists = $this->checkFileExists($downlad_filename, $compress_ext);

            if ($this->survey->getSurveyModel()->where('file_name', $original_filename)->count() == 0) {
                if (!$file_exists) {
                    $this->mylogger->logMessage("Downloading: " . $image_link ,$this,"info");
                    $this->downloadFile($downlad_filename, $image_link, $compress_ext);
                } else {
                    $this->_setFetchedFields($found_band, $obsid, $original_filename);
                    if (($this->survey->getSurveyParams('decompress'))) {
                        $this->mylogger->logMessage("Decompressing: " . $downlad_filename . $compress_ext ,$this,"info");
                        MyFunctions::decompressFile($downlad_filename . $compress_ext,
                            $this->survey->getSurveyParams('decompress'));
                    }
                }
            }
        }
        if (!empty($this->_fetchedfields)) {
            $this->slicer->fillFields($this->_fetchedfields);
        }

        return $this->slicer->sliceFields($this->cutoutSize, $this->bandsToFetch);
    }



    /**
     * push array of fetched fields into $this->_fetchedfields array
     * @param $found_band string band
     * @param $obsid string obsid parameter
     * @param $filename string filename parameter
     */
    private function _setFetchedFields($found_band, $obsid, $filename)
    {
        $fechedfields = [
            'band' => $found_band,
            'obsid' => $obsid,
            'file_name' => $filename
        ];

        array_push($this->_fetchedfields, $fechedfields);
    }


    /**
     * Extract from SIAP results only fields with recquired bands
     * @param $in_array array from SIAP
     * @return array of extracted fields
     */
    private function _extractBands($in_array)
    {
        $result = [];
        foreach ($in_array as $line) {
            @$found_band = $line[$this->survey->getSurveyParams('siapFields')->band];
            if (isset($found_band) && in_array($found_band, $this->survey->getSurveyParams('bands'))) {
                array_push($result, $line);
            }
        }
        return $result;
    }



}