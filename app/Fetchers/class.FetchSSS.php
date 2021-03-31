<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;

use MyPHP\MyFunctions;

class fetchSSS extends Fetcher implements FetchersInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchit()
    {

        $url = "http://www-wfau.roe.ac.uk/sss/cgi-bin/pixel.cgi";
        $referer = "http://www-wfau.roe.ac.uk/sss/pixel.html";

        $coords = trim(str_ireplace(":", " ", $this->qobject->getPNMainTable()->RAJ2000)) . " " . trim(str_ireplace(":",
                " ", $this->qobject->getPNMainTable()->DECJ2000));

        $wavebands = $this->survey->getSurveyParams('bands');

        $resultbands = [];

        foreach ($wavebands as $band => $waveband) {

            if (!$this->_testCoverage($waveband, $this->qobject->getPNMainTable()->DDECJ2000) || !in_array($band,
                    $this->bandsToFetch)
            ) {
                //TODO LOG
                continue;
            }

            $post_data = array(
                'coords' => $coords,
                'equinox' => "2",
                'size' => $this->cutoutSize / 60,
                'waveband' => $waveband,
                'gif' => "0"
            );

            $this->mylogger->logMessage("Submiting post request.", $this, 'info');
            $post_result = MyFunctions::post_request($url, $post_data, $referer);

            preg_match_all('/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?\.fits\.gz/',
                $post_result['content'], $match);

            if (!$match || empty($match)) {
                return $this->mylogger->logMessage("No results from the server.", $this, 'alert', false);
            }
            $resultsurl = $match[0][0];


            $resultbands[$band] = [
                'band' => $band,
            ];

            $tmpfile = tempnam(TMP_SSS, $band) . ".fits";
            $this->mylogger->logMessage("Downloading file.", $this, 'info');

            shell_exec("wget -O " . $tmpfile . ".gz " . $resultsurl);
            if (!is_file($tmpfile . ".gz")) {
                return $this->mylogger->logMessage("Problem with downloading.", $this, 'alert', false);
            }

            $this->mylogger->logMessage("Unziping file.", $this, 'info');
            shell_exec("gunzip " . $tmpfile . ".gz");

            $fieldno = $this->getHeaderItem($tmpfile, 'FIELDNUM');
            if (!$fieldno) {
                return $this->mylogger->logMessage("Problem with extracting field number ('FIELDNUM').", $this,
                    'alert',
                    false);
            }
            $file_name = $this->fitsName($this->survey->getSurveyParams('set'), $fieldno['FIELDNUM'],
                $this->qobject->getIdPNmain(), 1, $band);

            $this->mylogger->logMessage("Moving file.", $this, 'info');
            shell_exec("mv " . $tmpfile . " " . $this->outPath . $file_name);


            if (!is_file($this->outPath . $file_name)) {
                return $this->mylogger->logMessage("Problem with moving file.", $this, 'alert', false);
            }

            $resultbands[$band] = [
                'band' => $band,
                'filename' => $file_name,
                'field' => $fieldno['FIELDNUM']
            ];

        }

        $this->mylogger->logMessage("Finished collecting files.", $this, 'info');

        $fetchedfields = [
            'idPNMain' => $this->qobject->getIdPNmain(),
            'survey_name' => 'sss',
            'used_RAJ2000' => $this->qobject->getPNMainTable()->DRAJ2000,
            'used_DECJ2000' => $this->qobject->getPNMainTable()->DDECJ2000,
            'XcutSize' => $this->cutoutSize,
            'YcutSize' => $this->cutoutSize,
            'bands' => $resultbands,
            'attempt' => 'y'

        ];

        return MyFunctions::flattenArray($fetchedfields, 'bands');
    }

    private function _testCoverage($band, $dec)
    {
        $coverage = [
            'J' => ['decmin' => -90, 'decmax' => 3],
            'R' => ['decmin' => -90, 'decmax' => 3],
            'I' => ['decmin' => -90, 'decmax' => 3],
            'F' => ['decmin' => 2, 'decmax' => 90],
            'B' => ['decmin' => 2, 'decmax' => 90],
            'N' => ['decmin' => 2, 'decmax' => 90]
        ];
        $result = $dec > $coverage[$band]['decmin'] && $dec < $coverage[$band]['decmax'];
        return $result;
    }


}