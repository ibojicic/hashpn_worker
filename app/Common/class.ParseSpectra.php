<?php
namespace HashPN\App\Common;
/* Heavily hardcoded from the previous version
 TODO redo the whole class!! */


use HashPN\Models\MainGPN\ReferenceIDs;
use HashPN\Models\MainPNData\eELCAT;
use HashPN\Models\PNSpectra_Sources\FitsFiles;
use HashPN\Models\PNSpectra_Sources\spectraInfo;
use MyPHP\MyFunctions;
use MyPHP\MyPythons;
use MyPHP\MyStandards;

/**
 * Description of ParseSpectra
 *
 * @author ivan
 */
//class ParseSpectra extends FidoBrew {
class ParseSpectra
{

    use MyPythons;
    use MyStandards;

    private $_rewrite;
    private $_eselect;
    private $_outtxtfile;
    private $_hdrfields;
    private $_copypath;

    public function __construct($overwrite)
    {
        $this->_rewrite = $overwrite;
        $this->_hdrfields = [
            "dateObs" => array("DATE-OBS"),
            "observer" => array("OBSERVER"),
            "object" => array("OBJECT"),
            "instrument" => array("INSTRUME", "CAMERA", "DETECTOR"),
            "filter" => array("FILTER"),
            "telescope" => array("TELESCOP", "OBSERVAT"),
            "RAJ2000" => array("RA"),
            "DECJ2000" => array("DEC"),
            "DRAJ2000" => array("RA_OBS"),
            "DDECJ2000" => array("DEC_OBS")
        ];
        $this->_eselect = "`idPNMain` IS NOT NULL AND `InUse` = 1 ";
    }



    public function parseeELCATData($id)
    {
        $spectraldata = array();
        $tmpspectralData = array();
        $temp_elcat = eELCAT::where('idPNMain', $id)
            ->get()
            ->toArray();
        if (!$temp_elcat or empty($temp_elcat)) {
            return false;
        }
        foreach ($temp_elcat as $spectrum) {
            $spname = $spectrum["elcatCode"] . "_" . $spectrum["extinction_applied"];
            if (!isset($tmpspectralData[$spname])) {
                $tmpspectralData[$spname] = $this->_eelcatMeta($spectrum);
            }
            array_push($tmpspectralData[$spname]["data"],
                [$spectrum["wavelength"], -1, "-"],
                [$spectrum["wavelength"], $spectrum["Intensity"], $spectrum["ionic_id"]],
                [$spectrum["wavelength"], -1, "-"]);
            $tmpspectralData[$spname]["noLines"]++;
        }
        $this->_setCheckedPlots($tmpspectralData);
        $tmp1 = $tmpspectralData;
        foreach ($tmp1 as $spname => $tmp2) {
            $ref = $tmp2["label"];
            $sql_minmax = eELCAT::where('idPNMain', $id)
                ->where('elcatCode', $ref)
                ->select('wavelength')
                ->get()
                ->toArray();
            $minmax = MyFunctions::array_flatten($sql_minmax);
            $sql_min = min($minmax);
            $sql_max = max($minmax);
            if ($sql_min == $sql_max) {
                $minWav = $sql_min - 1000;
                $maxWav = $sql_min + 1000;
            } else {
                $minWav = $sql_min - ($sql_max - $sql_min) / 10;
                $maxWav = $sql_max + ($sql_max - $sql_min) / 10;
            }
            $tmpspectralData[$spname]["data"][0] = array($minWav, -1);
            array_push($tmpspectralData[$spname]["data"], array($maxWav, -1));
            if (!isset($spectraldata[$tmp2["int_scale"]])) {
                $spectraldata[$tmp2["int_scale"]] = array();
            }
            $spectraldata[$tmp2["int_scale"]][$spname] = $tmpspectralData[$spname];
        }
        if (isset($spectraldata["1.00E-14"])) {
            $spectraldata["maxline1"] = $this->_normalizeTotalSplines($spectraldata["1.00E-14"]);
            unset($spectraldata["1.00E-14"]);
        }
        if (isset($spectraldata["other"])) {
            $spectraldata["maxline2"] = $this->_normalizeTotalSplines($spectraldata["other"]);
            unset($spectraldata["other"]);
        }
        $relativescale = array();
        foreach ($spectraldata as $scale => $data) {
            if ($scale != "1.00E-14") {
                $relativescale = array_merge($relativescale, $data);
            }
        }
        if (!empty($relativescale)) {
            @$spline = json_encode($relativescale);
            MyFunctions::writeSpectraJson($spline,
                MyFunctions::pathslash("/data/kegs/spectraPlots/") . $id . "_synthspectrarelative.txt", true);
        }
        return true;
    }

    private function _eelcatMeta($spectrum)
    {
        $res_link = ReferenceIDs::where('elcatCode', $spectrum['elcatCode'])
            ->select(['Identifier', 'Author', 'Year'])
            ->first()
            ->toArray();
        $tmpspectralData = [
            "label" => $spectrum['elcatCode'],
            "ref" => strlen($res_link["Author"]) > 60 ? substr($res_link["Author"], 0,
                    60) . "..." : $res_link["Author"],
            "year" => $res_link["Year"],
            "int_scale" => $spectrum["int_scale"],
            "extinction_applied" => $spectrum["extinction_applied"],
            "link" => MyFunctions::adsLink($res_link["Identifier"]),
            "xaxis" => 1,
            "yaxis" => 1,
            "noLines" => 0,
            "checked" => "",
            "data" => [0]
        ];
        return $tmpspectralData;
    }

    private function _setCheckedPlots(&$plotsdata)
    {
        $tmparray = array();
        foreach ($plotsdata as $key => $vals) {
            if (!isset($tmparray[$vals["int_scale"]])) {
                $tmparray[$vals["int_scale"]] = array();
            }
            $tmparray[$vals["int_scale"]][$key] = -1 * $vals["noLines"];
        }
        foreach ($tmparray as $intscale => $tmdata) {
            $maxchecked = $intscale == "H-beta" ? 3 : 1;
            asort($tmdata);
            $k = 0;
            foreach (array_keys($tmdata) as $key) {
                $plotsdata[$key]["checked"] = "checked";
                $k++;
                if ($k == $maxchecked) {
                    break;
                }
            }
        }
        return true;
    }

    private function _normalizeTotalSplines($data)
    {
        $tmpdata = $data;
        $norm = false;
        foreach ($data as $ref => $dataset) {
            $max = -1;
            foreach ($dataset["data"] as $lints) {
                if ($lints[1] > $max) {
                    $norm = $lints[2];
                    $max = $lints[1];
                }
            }
            foreach ($dataset["data"] as $dints => $lints) {
                if ($tmpdata[$ref]["data"][$dints][1] > 0) {
                    $tmpdata[$ref]["data"][$dints][1] = $tmpdata[$ref]["data"][$dints][1] / $max * 100;
                }
            }
            $tmpdata[$ref]["int_scale"] = $norm;
        }
        return $tmpdata;
    }

    public function setPaths($id)
    {
        $results = 'nok';
        $this->_copypath = ("/data/fermenter/PNImages/") . $id . "/SPECTRA/";
        if (!is_dir($this->_copypath)) {
            $python_mkdir = MyFunctions::pathslash(PY_DRIVER_DIR) . "mkdir_driver.py";
            $results = $this->PythonToPhp($python_mkdir, ['folder' => $this->_copypath], 'local', true);
        }
        return $results == 'ok';
    }

    public function setOutTxtFile($id)
    {
        $this->_outtxtfile = MyFunctions::pathslash("/data/kegs/spectraPlots/") . $id . "_spctr.txt";
    }

    public function getBasicData($id, $setname)
    {
        $results = [];
        $checkparsed = FitsFiles::where('idPNMain', $id)
            ->where('parsedIn', 'n')
            ->where('InUse', 1)
            ->where('setname', $setname)
            ->get()
            ->toArray();
        if ((!empty($checkparsed) and $checkparsed) or $this->_rewrite) {
            $fitsdata = FitsFiles::where('idPNMain', $id)
                ->where('InUse', 1)
                ->where('setname', $setname)
                ->get();
            if ($fitsdata) {
                foreach ($fitsdata as $fits) {
                    $result_spectra = $fits
                        ->spectraInfo
                        ->toArray();
                    $result_fits = $fits
                        ->toArray();
                    array_push($results, $result_fits);//array_merge($result_fits,$result_spectra));
                }
            }
        }
        return $results;
    }

    public function copySpectra($spdata)
    {
        $extension = $spdata['convToText'] == "y" ? "fits" : "dat";
        $newfilename = $this->_setOutSpectraName($spdata['setname'], $spdata['fileName'], $spdata['idPNMain'],
            $extension);
        $command = "cp /data/mashtun/" . $spdata['spectra_info']['path'] . $spdata['fileName'] . " " . $this->_copypath . $newfilename;
        shell_exec($command);
        $spdata['newFileName'] = $newfilename;
        $spdata['newpath'] = $this->_copypath;
        return $spdata;
    }

    private function _setOutSpectraName($set, $filename, $id, $type = "fits")
    {
        $filename = str_ireplace(".fit", "", str_ireplace(".fits", "", $filename));
        return $set . "_" . $filename . "_id" . $id . "." . $type;
    }

    public function setObjectsSpectraFile($id, $files, $overwrite = true)
    {

        $tmpdir = $this->getTempDir("/tmp/", 'spec', true);
        $tempfile = MyFunctions::pathslash($tmpdir) . MyFunctions::genRandomString() . "_tempspectra.txt";
        ini_set('memory_limit', '512M');
        if (is_dir($this->_copypath) and !empty($files)) {
            if (!is_file($this->_outtxtfile) or $overwrite) {
                $tmpspectralData = array();
                $k = 0;
                foreach ($files as $filedata) {
                    echo "file\n";
                    echo memory_get_peak_usage(true) / (1024 * 1024) . "\n";
                    if (memory_get_peak_usage(true) / (1024 * 1024) < 500) {
                        if ($filedata['convToText'] == 'y') {
                            echo "fits file............\n";
                            $inputarray = array(
                                "infile" => $filedata['newpath'] . $filedata['newFileName'],
                                "outfile" => $tempfile,
                                "parser" => $filedata['parserflag']
                            );
                            // TODO
                            $python_parse_spec = MyFunctions::pathslash(PY_DRIVER_DIR) . "make_text_spect_driver.py";
                            $python_response = $this->PythonToPhp($python_parse_spec, $inputarray, 'local', true);
                        } else {
                            echo "ascii file............\n";
                            system("cp " . $filedata['newpath'] . $filedata['newFileName'] . " " . $tempfile);
                            $python_response = array(0 => "ok");
                        }
                        if (is_file($tempfile) and $python_response and $python_response[0] == "ok") {
                            $dataarray = $this->_convtoarray($tempfile, $filedata['ascii'] = "y", $filedata['xfactor']);
                            $checkedflag = false;
                            if ($dataarray) {

                                $checkedflag = true;
                                foreach ($dataarray as $datakey => $datavar) {
                                    $k++;
                                    $data = $datavar['normalized'];
                                    $minwav = floor($datavar['normalized'][0][0]);
                                    $maxwav = floor($datavar['normalized'][count($datavar['normalized']) - 1][0]);
                                    $tmpspectralData[$k] = array(
                                        'label' => $k,
                                        'file' => $filedata['newFileName'],
                                        'link' => "download.php?p=s&f=" . $id . "/SPECTRA/" . $filedata['newFileName'],
                                        'ref' => $filedata['reference'],
                                        'data' => $data,
                                        'dateobs' => $filedata['dateObs'] == "0000-00-00" ? "-" : $filedata['dateObs'],
                                        'instrument' => $filedata['instrument'] == "" ? "-" : $filedata['instrument'],
                                        'filter' => $filedata['filter'] == "" ? "-" : $filedata['filter'],
                                        'telescope' => $filedata['telescope'] == "" ? "-" : $filedata['telescope'],
                                        'xaxis' => 1,
                                        'yaxis' => 1,
                                        'checked' => $filedata['checked'],
                                        'min' => $minwav,
                                        'max' => $maxwav,
                                        'rebinned' => $datavar['rebinned']
                                    );

                                    if ($filedata['checked'] !== "") {
                                        $checkedflag = false;
                                    }
                                    $this->_updateParsedIn($id, $filedata['fileName'], $filedata['newFileName']);
                                }
                            }
                            // if none of the spectra is checked by default check the first one
                            if ($checkedflag) {
                                $tmpspectralData[1]['checked'] = "checked";
                            }
                        }
                    }
                }

                @$spline = json_encode($tmpspectralData) . "\n";
                $fp = fopen($this->_outtxtfile, "w");
                fwrite($fp, $spline);
                fclose($fp);
            }
        }
        if (is_file($tempfile)) {
            unlink($tempfile);
        }
        if (is_dir($tmpdir)) {
            rmdir($tmpdir);
        }
        return;
    }

    private function _convtoarray($file, $ascii, $xfac = 1)
    {
        $result = array();
        $x = 0;
        $data = file($file);
        if (count($data) == 0) {
            return false;
        }
        $tmpres = array();
        $rebinned = "no";
        if ($ascii) {
            foreach ($data as $line) {
                if (stripos($line, "rebinned:") === false) {
                    $line = preg_replace('/\s+/', ' ', trim($line));
                    $chunks = explode(" ", $line);
                    if (count($chunks) >= 2) {
                        $x = floatval($chunks[0]) * floatval($xfac);
                    }
                    $y = floatval($chunks[1]);
                    if ($x > 0) {
                        array_push($tmpres, array($x, $y, '-'));
                    }
                } else {
                    $rebinned = str_ireplace("rebinned:", "", $line);
                }
            }

            $normalized = $this->_normalizeArrays($tmpres);
            $normalized['rebinned'] = $rebinned;
            array_push($result, $normalized);
        }
        return $result;
    }

    private function _normalizeArrays($inarray)
    {
        $result = $inarray;
        $tmpvals = array();
        foreach ($inarray as $dt) {
            array_push($tmpvals, $dt[1]);
        }
        $min = min($tmpvals);
        $max = max($tmpvals);
        $median = MyFunctions::median($tmpvals);
        $offset = -1 * $median;
        $norma = $max / 100;
        foreach ($inarray as $key => $val) {
            $result[$key][1] = ($val[1] + $offset) / $norma;
        }
        return array("normalized" => $result, "min" => $offset / $norma);
    }


    private function _updateParsedIn($id, $file, $newfile)
    {
        $finished = FitsFiles::where('idPNMain', $id)
            ->where('fileName', $file)
            ->first();
        $finished->parsedIn = 'y';
        $finished->outName = $newfile;
        return $finished->save();
    }

    private function _parseFitsKeys()
    {
        $result = array();
        foreach ($this->_hdrfields as $field) {
            foreach ($field as $val) {
                array_push($result, $val);
            }
        }
        return $result;
    }


    public function SPECTRA_dbfiller($surveys)
    {
        foreach ($surveys as $name) {
            $survey = spectraInfo::where('name', $name)
                ->first();
            $files = glob("/data/mashtun/" . $survey->path . "*");
            $parsekeys = $this->_parseFitsKeys();
            foreach ($files as $file) {
                $filename = trim(str_ireplace("/data/mashtun/" . $survey->path, "", trim($file)));
                $insarray = array(
                    'fileName' => $filename,
                    'setname' => $survey->name,
                    'date' => date("Y-m-d H:i:s")
                );
                $sql_check = FitsFiles::where('fileName', $filename)
                    ->where('setname', $survey->name)
                    ->get()
                    ->toArray();
                if (!$sql_check) {
                    $parsedresults = false;
                    if ($survey->type == "fits") {
                        $input_array = array('filename' => $file, 'keys' => $parsekeys);
                        $python_fill_spec = MyFunctions::pathslash(PY_DRIVER_DIR) . "spectra_filler_driver.py";
                        $python_response = $this->PythonToPhp($python_fill_spec, $input_array, 'local', true);
                        if ($python_response['pass'] == 'ok') {
                            $parsedresults = array();
                            foreach ($python_response['result'] as $key => $val) {
                                if ($key == $this->_hdrfields['dateObs'][0]) {
                                    $temp = date_parse($val);
                                    $currval = (!$temp['year'] or !$temp['month'] or !$temp['day']) ? false : $temp['year'] . "-" . $temp['month'] . "-" . $temp['day'];
                                    if ($currval) {
                                        $val = $currval;
                                    } else {
                                        $val = false;
                                    }
                                }
                                if ($val and trim($val) != "") {
                                    foreach ($this->_hdrfields as $hkey => $hvals) {
                                        if (in_array($key, $hvals)) {
                                            $parsedresults[$hkey] = mysql_escape_string(trim($val));
                                        }
                                    }
                                }
                            }
                        }
                    } elseif ($filename != "header.hdr") {
                        $parsedresults = array();
                        $tmpeader = file("/data/mashtun/" . $survey->path . "header.hdr");
                        foreach ($tmpeader as $line) {
                            $chunks = explode(",", $line);
                            if (trim($chunks[1]) != "null") {
                                $parsedresults[$chunks[0]] = trim($chunks[1]);
                            }
                        }
                    }
                    if ($parsedresults) {
                        $FitsFiles = new FitsFiles();
                        $founddata = array_intersect_key(array_merge($parsedresults, $insarray),
                            array_flip($FitsFiles->getFillable()));
                        $FitsFiles->create($founddata);
                    }
                } else {
//                    echo "File is already in....\n";
                }
            }
        }
    }

    /* TODO */
//    public function updateSpectraSample() {
//        $query = "UPDATE `MainPNSamples`.`availableSpectrum` SET `spectrum` = 'n';";
//        // TODO
//        $this->_mysqldriver->query($query);
//        $query = "UPDATE `MainPNSamples`.`availableSpectrum` SET `spectrum` = 'y'
//                        WHERE `idPNMain` IN (SELECT `idPNMain` FROM PNSpectra_Sources.FitsFiles
//                        WHERE `idPNMain` IS NOT NULL
//                        GROUP BY `idPNMain`);";
//        // TODO
//        $this->_mysqldriver->query($query);
//    }


}

?>
