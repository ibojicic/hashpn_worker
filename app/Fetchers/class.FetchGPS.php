<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;

use MyPHP\MyFunctions;

class fetchGPS extends Fetcher implements FetchersInterface
{

    public function __construct()
    {
        parent::__construct();
    }


    public function fetchit()
    {

        $url = "http://first.astro.columbia.edu/cgi-bin/third/gpscutout";
        $referer = "http://first.astro.columbia.edu/cgi-bin/third/gpscutout";

        $coords = trim(str_ireplace(":", " ", $this->qobject->getPNMainTable()->Glon)) . " " . trim(str_ireplace(":",
                " ", $this->qobject->getPNMainTable()->Glat));

        $wavebands = $this->survey->getSurveyParams('bands');

        $resultbands = [];

        foreach ($wavebands as $band => $waveband) {

            if (!$this->_testCoverage($waveband, $this->qobject->getPNMainTable()->Glon,
                    $this->qobject->getPNMainTable()->Glat) || !in_array($band, $this->bandsToFetch)
            ) {
                //TODO LOG
                continue;
            }

            $post_data = array(
                'Survey' => $waveband,
                'RA' => $coords,
                'Dec' => '',
                'Equinox' => 'Galactic',
                'ImageSize' => 3 * $this->cutoutSize / 60,
                'ImageType' => 'FITS image',
                'Epochs' => '',
                'Fieldname' => '',
                'submit' => ' Extract the Cutout '
            );


            $file_name = $this->fitsName($this->survey->getSurveyParams('set'), "",
                $this->qobject->getIdPNmain(), 1, $band);

            $this->mylogger->logMessage("Submiting post request.", $this, 'info');

            $resultbands[$band] = [
                'band' => $band,
            ];

            $this->mylogger->logMessage("Downloading file.", $this, 'info');
            $download_result = MyFunctions::curl_post_request($url, $post_data, $this->outPath . $file_name, $referer);
            if ($download_result) {
                $this->mylogger->logMessage("Finished downloading.", $this, 'info');
                $resultbands[$band] = [
                    'band' => $band,
                    'filename' => $file_name
                ];
            } else {
                $this->mylogger->logMessage("Problem with downloading.", $this, 'critical');
            }
        }

        $this->mylogger->logMessage("Finished collecting files.", $this, 'info');

        $fetchedfields = [
            'idPNMain' => $this->qobject->getIdPNmain(),
            'survey_name' => 'gps',
            'used_RAJ2000' => $this->qobject->getPNMainTable()->DRAJ2000,
            'used_DECJ2000' => $this->qobject->getPNMainTable()->DDECJ2000,
            'XcutSize' => $this->cutoutSize,
            'YcutSize' => $this->cutoutSize,
            'bands' => $resultbands,
            'attempt' => 'y'

        ];

        return MyFunctions::flattenArray($fetchedfields, 'bands');
    }


    private function _testCoverage($band, $glon, $glat)
    {
        $result = false;
        $coverage = [
            "gps6" => [0 => ['glonmin' => 350, 'glonmax' => 42, 'glatmin' => -0.4, 'glatmax' => 0.4]],
            "gps6epoch2" => [0 => ['glonmin' => 28, 'glonmax' => 33.5, 'glatmin' => -1, 'glatmax' => 1]],
            "gps6epoch3" => [0 => ['glonmin' => 20.5, 'glonmax' => 33.5, 'glatmin' => -1, 'glatmax' => 1]],
            "gps6epoch4" => [0 => ['glonmin' => 20.5, 'glonmax' => 33.5, 'glatmin' => -1, 'glatmax' => 1]],

            "gps20" => [
                0 => ['glonmin' => 340, 'glonmax' => 120, 'glatmin' => -0.8, 'glatmax' => 0.8],
                1 => ['glonmin' => 350, 'glonmax' => 40, 'glatmin' => 100, 'glatmax' => 105],
                2 => ['glonmin' => 1.7, 'glonmax' => 1.7, 'glatmin' => -2.2, 'glatmax' => 2.2]
            ],
            "gps20new" => [0 => ['glonmin' => 5, 'glonmax' => 48, 'glatmin' => -0.8, 'glatmax' => 0.8]],
            "gps90" => [0 => ['glonmin' => 3.6, 'glonmax' => 33.2, 'glatmin' => -2, 'glatmax' => 2]],
        ];
        foreach ($coverage[$band] as $strips) {
            if ($strips['glonmin'] > $strips['glonmax']) {
                $glonbool = ($glon > $strips['glonmin'] && $glon < 360) || ($glon > 0 && $glon < $strips['glonmax']);
            } else {
                $glonbool = $glon > $strips['glonmin'] && $glon < $strips['glonmax'];
            }
            $glatbool = $glat > $strips['glatmin'] && $glat < $strips['glatmax'];
            $result = $result || ($glonbool && $glatbool);
        }
        return $result;
    }


}