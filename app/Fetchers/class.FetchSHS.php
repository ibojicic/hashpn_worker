<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;

use MyPHP\MyFunctions;

class fetchSHS extends Fetcher implements FetchersInterface
{


    public function __construct()
    {
        parent::__construct();
    }


    public function fetchit()
    {

        if ($this->qobject->getPNMainTable()->DDECJ2000 > 5 || abs($this->qobject->getPNMainTable()->Glat) > 15) {
            return $this->mylogger->logMessage("Object is outside of the coverage.", $this, 'alert', false);
        }

        $url = "http://www-wfau.roe.ac.uk/sss/cgi-bin/hapixel.cgi";
        $referer = "http://www-wfau.roe.ac.uk/sss/halpha/hapixel.html";

        $coords = trim(str_ireplace(":", " ", $this->qobject->getPNMainTable()->RAJ2000)) . " " . trim(str_ireplace(":",
                " ", $this->qobject->getPNMainTable()->DECJ2000));

        $post_data = [
            'coords' => $coords,
            'equinox' => "2",
            'size' => $this->cutoutSize / 60,
            'sizey' => $this->cutoutSize / 60,
            'waveband' => "3",
            'output' => "4",
            'gif' => "0"
        ];

        $this->mylogger->logMessage("Submiting post request.", $this, 'info');
        $post_result = MyFunctions::post_request($url, $post_data, $referer);

        preg_match_all('/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?\.fits\.gz/', $post_result['content'],
            $match);

        if (!$match || empty($match)) {
            return $this->mylogger->logMessage("No results from the server.", $this, 'alert', false);
        }

        $resultsurl = [
            'ha' => $match[0][0],
            'sr' => $match[0][2]
        ];


        $bands = [];

        foreach ($this->bandsToFetch as $band) {
            $bands[$band] = [
                'band' => $band,
            ];
            $tmpfile = tempnam(TMP_SHS, $band) . ".fits";
            $this->mylogger->logMessage("Downloading file.", $this, 'info');

            shell_exec("wget -O " . $tmpfile . ".gz " . $resultsurl[$band]);
            if (!is_file($tmpfile . ".gz")) {
                return $this->mylogger->logMessage("Problem with downloading.", $this, 'alert', false);
            }

            $this->mylogger->logMessage("Unziping file.", $this, 'info');
            shell_exec("gunzip " . $tmpfile . ".gz");

            $fieldno = $this->getHeaderItem($tmpfile, 'FIELDNUM');
            if (!$fieldno) {
                return $this->mylogger->logMessage("Problem with extracting field number ('FIELDNUM').", $this, 'alert',
                    false);
            }
            $file_name = $this->fitsName($this->survey->getSurveyParams('set'), $fieldno['FIELDNUM'],
                $this->qobject->getIdPNmain(), 1, $band);

            $this->mylogger->logMessage("Moving file.", $this, 'info');
            shell_exec("mv " . $tmpfile . " " . $this->outPath . $file_name);

            if (!is_file($this->outPath . $file_name)) {
                return $this->mylogger->logMessage("Problem with moving file.", $this, 'alert', false);
            }

            $bands[$band] = [
                'band' => $band,
                'filename' => $file_name,
                'field' => $fieldno['FIELDNUM']
            ];

        }

        $this->mylogger->logMessage("Finished collecting files.", $this, 'info');

        $fetchedfields = [
            'idPNMain' => $this->qobject->getIdPNmain(),
            'survey_name' => 'shs',
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