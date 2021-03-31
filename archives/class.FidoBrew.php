<?php
namespace HashPN\App\Common;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class
 *
 * @author ibojicic
 */
class FidoBrew {
    
    protected $_mysqldriver;
    protected $_pngInfoTables;
    protected $_fitsInfoTables;
    protected $_objectId = False;    
    protected $_basepathPNG = False;
    protected $_outpathPNG = False;
    protected $_basepathFITS = False;
    protected $_set = False;
    protected $_objData = array();
    protected $_extraselect = "";

    public $tmpdir;
    public $recordtodb = True;
    public $fitsImageSets = array();


    public function __construct($myConfig, $imageInfoTables = array()) {
        $this->_mysqldriver = new MysqlDriver($myConfig['dbhost_admin'], $myConfig['dbuser_admin'], $myConfig['dbpass_admin']);
        if (isset($imageInfoTables['pngimginfoTable'])) $this->_pngInfoTables = $imageInfoTables['pngimginfoTable'];
        if (isset($imageInfoTables['fitsimginfoTable'])) $this->_fitsInfoTables = $imageInfoTables['fitsimginfoTable'];
        
    }
    
    /**
     * make temporary folder and store it in public tmpdir (no slash at the end)
     * @return bolean : True on success, False on failure
     */
    public function settempdir() {
        $rand = genRandomString(10);
        $this->tmpdir = pathslash(pathslash(WORKDISC) . TMPFIDO) . $rand;
        mkdir($this->tmpdir);
        return is_dir($this->tmpdir);
    }    
    /**
     * add extra selection into mysql statement i.e. WHERE ....
     * @param string $where MySQL WHERE selection
     */
    public function setExtraSelect($where = False) {
        if ($where) {
            $this->_extraselect = $this->_extraselect == "" ? $this->_extraselect = " WHERE " : $this->_extraselect . " AND ";
            $this->_extraselect .= " " . $where . " ";
        }
    }
    
    
    
    /**
     * set main path (public inpathPNG) for PNG images i.e. ../../idPNMain/
     */
    protected function _setBasePathPNG() {
        $this->_basepathPNG = pathslash(pathslash(USE_PNGPNIMAGES) . $this->_objectId);
    }
    
    /**
     * make main path folder for PNG images i.e. ../../idPNMain/
     */
    protected function _makeBasePathPNG() {
        if (!$this->_basepathPNG) $this->_setBasePathPNG();
        if (!is_dir($this->_basepathPNG)) mkdir ($this->_basepathPNG);
        return is_dir($this->_basepathPNG);
    }
    
    /**
     * set current id (protected _objectId)
     */
    public function setObjectId($id) {
        $this->_objectId = $id;
    }
    
    /**
     * 
     * set current set (protected _set) i.e. 2mass
     * @param string $set
     */
    protected function _setSet($set) {
        $this->_set = $set;
    }
    
    /**
     * set path folder (protected _outpathPNG) for PNG images i.e. ../../idPNMain/set/
     */
//    protected function _setOutPathPNG() {
//        if (!$this->_basepathPNG) $this->_setBasePathPNG();
//        $this->_outpathPNG = pathslash(pathslash($this->_basepathPNG) . $this->_pngInfoTables[$this->_set]['outFolder']);
//    }

    /**
     * make folder for PNG images i.e. ../../idPNMain/set/
     */
    
    protected function _makeOutPathPNG() {
        if (!$this->_basepathPNG) $this->_makeBasePathPNG();
        if (!$this->_outpathPNG) $this->_setOutPathPNG();
        if (!is_dir($this->_outpathPNG)) mkdir($this->_outpathPNG);
        return is_dir($this->_outpathPNG);
    }
    
    /**
     * select pre-selected user sample
     * @param string $sample name of the sample
     * @return string list of ids i.e. 8,9,13,456
     */
    public function setUserSample($sample) {
        $sql_select = "SELECT `sample` FROM `" . MAIN_SAMPLES . "`.`userSamples` WHERE sampleName = '".$sample."';";
        $samplelist = $this->_mysqldriver->selectquery($sql_select);
        if (!$sample) return False;
        return $samplelist[0]['sample'];  
    }
    
    /**
     * set main path (public _basepathFITS) for FITS images i.e. ../../idPNMain/
     */
//    public function _setBasePathFITS() {
//        $this->_basepathFITS = pathslash(pathslash(USE_PNIMAGES) . $this->_objectId);
//    }

    /**
     * creates folder for objects fits cutouts ../../idPNMain/
     * @return bolean : True on success, False on failure
     */
    public function makeBasePathFITS() {
        if (!$this->_basepathFITS) $this->_setBasePathFITS ();
        if (!is_dir($this->_basepathFITS)) mkdir($this->_basepathFITS);
        return is_dir($this->_basepathFITS);
    }
    
    /**
     * specifies objects fits coutout string for set ../../idPNmain/set/
     * @param string $kset set name
     * @param string $imagepath specific image path
     * @return string path
     */
//    public function getOutFolderFits($kset) {
//        if (!$this->_basepathFITS) $this->_setBasePathFITS();
//       return pathslash(pathslash($this->_basepathFITS) . $this->fitsImageSets[$kset]['folder']);
//    }

    /**
     * stores objects fits path string for set ../../idPNmain/set/
     * in $this->_objData['outpath']
     * @param string $kset set name
     * @param string $imagepath specific image path
     */
    public function setOutFolderFits($kset) {
        $this->_objData['outpath'] = $this->getOutFolderFits($kset);
    }
    
    /**
     * creates folder to store fits cutouts ../../idPNMain/set/
     * @return bolean : True on success, False on failure
     */
    public function makeOutFolder() {        
        if (!isset($this->_objData['outpath'])) return False;
        if (!is_dir($this->_objData['outpath']))
            mkdir($this->_objData['outpath']);
        return is_dir($this->_objData['outpath']);
    }
    
    
    /**
     * get basic data for making object's cutout
     * @return array of data
     */
    public function getObjectData() {
        $sql = "SELECT `" . MAIN_ID . "` , `" . MAIN_DESIGNATION . "` ,
				`RAJ2000`,`DECJ2000`,
				`DRAJ2000`, `DDECJ2000`,
				`Glon`, `Glat`,
				`MajExt`,`MajDiam`
				FROM `" . MAIN_DB . "`.`" . VIEW_TABLE . "`
				WHERE `" . MAIN_ID . "` = ".$this->_objectId.";";
        $res = $this->_mysqldriver->selectquery($sql);
        if (!isset($res[0]['MajDiam']) or trim($res[0]['MajDiam']) == "")
            $res[0]['MajDiam'] = 0;
        if (!isset($res[0]['MajExt']) or trim($res[0]['MajExt']) == "")
            $res[0]['MajExt'] = $res[0]['MajDiam'];
        if ($res[0]['MajExt'] < $res[0]['MajDiam'])
            $res[0]['MajExt'] = $res[0]['MajDiam'];
        $this->_objData = $res[0];
        return;
    }
    
    
    /*
     * parse `PNImages`.`imagesets` table
     * input: where -> specifics for the sql query
     * output: outArray -> array
     */
    public function fillSurveyData() {
        $raw = $this->_mysqldriver->selectquery("SELECT * FROM `" . MAIN_IMAGES . "`.`imagesets` WHERE `use` = 'y';");
        $result = array('survey_data' => array(), 'surveys' => array());
        foreach ($raw as $data) {
            $tmpdata = $data;
            $tmp4 = array();
            $tmp1 = explode(",", $data['bands']);
            $ttmp1 = explode(";", $data['images']);
            foreach ($tmp1 as $tmp2) {
                $tmp3 = explode(";", $tmp2);
                $tmp4[$tmp3[0]] = isset($tmp3[1]) ? $tmp3[1] : array();
            }
            unset($tmpdata['bands'], $tmpdata['images']);
            $tmpdata['bands'] = $tmp4;
            $tmpdata['images'] = $ttmp1;
            $tmp4 = explode(",",$data['extrafields']);
            $tmpextra = array();
            foreach ($tmp4 as $tmp5) {                
                $tmp6 = explode(":",$tmp5);
                if (is_array($tmp6) and trim($tmp6[0]) != "") $tmpextra[$tmp6[0]] = $tmp6[1];
            }
            $tmpdata['extrafields'] = empty($tmpextra) ? False : $tmpextra;
            $result['survey_data'][$data['set']] = $tmpdata;
            array_push($result['surveys'], $data['set']);
        }
        $this->fitsImageSets = $result['survey_data'];
        return $result;
    }
    
    /**
     * parse results from siam request
     * @param string $query
     * @param string $set
     * @param array $input_array
     * @return type
     */
    protected function _getSiapResults($query, $set, $input_array) {
        $rndadd = genRandomString();
        $xmlfile = "/data/copper/" . $set . "siap_" . $rndadd . ".xml";
        $fp = fopen($xmlfile, "w");
        fwrite($fp, $query);
        fclose($fp);
        if (isset($input_array["xmltable"]))
            die("xmltable key is reserved for siap parser!!!");
        $input_array["xmltable"] = $xmlfile;
        /*
          "imurlfield"    => $imageurl,
          "bandfield"     => $band
          );
         * 
         */
        $results = pythonToPhp("siap_parser.py", $input_array);
        unlink($xmlfile);
        return $results;
    }
    
    /**
     * finds value from fits header
     * @param string $image path to fits image
     * @param string $item item from fits header
     * @return string item's value ('error' on error)
     */
    protected function _getHeaderItem($image,$item) {
        $result = pythonToPhp("finditemfromheader.py", array("inFile" => $image, "key" => $item, "phpflag" => ""));
        return $result == "error" ? False : $result;
    }
    
    /**
     * constructs fits coutout name
     * @param string $kset set
     * @param string $field field name
     * @param integer $id id of the object
     * @param integer $bin bin size
     * @param string $band band
     * @return string
     */
    public function fitsName($kset,$field,$id,$bin,$band) {
        $field = $field ? "_" . trim($field) : "";
        return $kset . $field ."_id". $id ."_b". $bin ."_w". $band .".fits";
    }

    /**
     * 
     * @param string $kset set name
     * @return string mysql table format i.e. `DB`.`Table`
     */
    public function getFitsTable($kset) {
        return "`" . MAIN_IMAGES . "`.`" . $this->fitsImageSets[$kset]['imagestable'] . "`";
    }
            
    
     /*
     * Send a post request and retrieve/parse the html page
     * input:url, data (array), referer
     *
     * output: array =>
     * if ok: status = ok, header, content
     * in not ok: status = err, error (error string)
     */

    public function post_request($url, $data, $referer = '') {

        // Convert the data array into URL Parameters like a=b&foo=bar etc.
        $data = http_build_query($data);

        // parse the given URL
        $url = parse_url($url);

        if ($url['scheme'] != 'http') {
            die('Error: Only HTTP request are supported !');
        }

        // extract host and path:
        $host = $url['host'];
        $path = $url['path'];

        // open a socket connection on port 80 - timeout: 30 sec
        $fp = fsockopen($host, 80, $errno, $errstr, 30);

        if ($fp) {

            // send the request headers:
            fputs($fp, "POST $path HTTP/1.1\r\n");
            fputs($fp, "Host: $host\r\n");

            if ($referer != '')
                fputs($fp, "Referer: $referer\r\n");

            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            //fputs($fp, "Content-type: multipart/form-data\r\n");
            fputs($fp, "Content-length: " . strlen($data) . "\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $data);

            $result = '';


            while (!feof($fp)) {
                // receive the results of the request
                $result .= fgets($fp);
            }
        }
        else {
            return array(
                'status' => 'err',
                'error' => "$errstr ($errno)"
            );
        }

        // close the socket connection:
        fclose($fp);

        // split the result header from the content
        $result = explode("\r\n\r\n", $result, 2);

        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';

        // return as structured array:
        return array(
            'status' => 'ok',
            'header' => $header,
            'content' => $content
        );
    }

    /*
     * Send a post request and retrieve a file from the html page
     * input:url, data (array), fileout, referer
     *
     * output: True or False
     */

    public function curl_post_request($url, $data, $fileout, $referer = '') {
        $result = True;
        // Convert the data array into URL Parameters like a=b&foo=bar etc.
        $data_string = http_build_query($data);
        // Create an empty file to write in
        $fp = fopen($fileout, "w");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($data_string));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 250);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, False);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (file_put_contents($fileout, curl_exec($ch)) === false) {
            unlink($fileout);
            $result = False;
        }
        //close connection
        curl_close($ch);
        fclose($fp);
        if (filesize($fileout) < 10*1024) {
            unlink($fileout);
            $result = False;
        }
        return $result;
    }

  
    
    public function deleteSet($id, $kset,$fits = False,$pngs = False) {
        if (!$this->recordtodb) return False;
        $fitstable = $this->getFitsTable($kset);
        $pathtofits = $this->getOutFolderFits($kset);
        $fitstableid = "id".$this->fitsImageSets[$kset]['imagestable'];
        $sql = $this->_mysqldriver->select(array("filename",$fitstableid),$fitstable,"`".MAIN_ID."` = ".$id." "
                . "AND `found` = 'y' AND `filename` IS NOT NULL");
        $sqldelete = "DELETE FROM ".$fitstable." WHERE `".MAIN_ID."` = ".$id;
        $this->_mysqldriver->query($sqldelete);
        if ($sql) {
            foreach ($sql as $sqlres) {
                $pathtofile = pathslash($pathtofits).$sqlres['filename'];
                $shortpath = pathslash($this->fitsImageSets[$kset]['folder']).$sqlres['filename'];
                //system("rm -rf ".$pathtofits);
                if (is_file($pathtofile)) system ("rm ".$pathtofile);
                $sqlpng = $this->_mysqldriver->select(array("OUT_DIR","OutImage","id".MAIN_pngIMAGES,"rgb_cube"),"`".MAIN_IMAGES."`.`".MAIN_pngIMAGES."`",
                        "`in` = '".$shortpath."' OR " .
                        "`R` = '".$shortpath."' OR " .
                        "`G` = '".$shortpath."' OR " .
                        "`B` = '".$shortpath."'");
                if ($sqlpng) {
                    foreach ($sqlpng as $sqlpngres) {
                        if (is_file($sqlpngres["rgb_cube"]."_2d.fits")) system("rm ".$sqlpngres["rgb_cube"]."_2d.fits");
                        if (is_file($sqlpngres["rgb_cube"].".fits")) system("rm ".$sqlpngres["rgb_cube"].".fits");
                        $posres = glob(pathslash($sqlpngres['OUT_DIR']).$sqlpngres['OutImage']."*");
                        $this->_mysqldriver->query("DELETE FROM `".MAIN_IMAGES."`.`".MAIN_pngIMAGES."` WHERE id".MAIN_pngIMAGES." = ".
                                    $sqlpngres["id".MAIN_pngIMAGES].";");
                        foreach ($posres as $pngfile) if (is_file($pngfile)) system("rm ".$pngfile);
                    }
                }
            }
        }
       
        
    }
    
    /**
     * checks if path is properly construncted
     * @param string $path
     * @param string $kset
     * @return boolean
     */
    protected function _checkOutpath($path,$kset) {
        if (!isset($this->_objectId) or trim($this->_objectId) == "" or !is_numeric($this->_objectId)) return False;
        if (trim(USE_PNIMAGES) == "") return False;
        if (!isset($kset) or trim($kset) == "" or trim($kset) == "." or trim($kset) == "..") return False;
        return pathslash(pathslash(pathslash(USE_PNIMAGES) . $this->_objectId ).$kset) == $path;
    }

    public function resetObjectVars() {
        $this->_objectId    = False;    
        $this->_basepathPNG = False;
        $this->_outpathPNG  = False;
        $this->_outpathFITS = False;
        $this->_basepathFITS= False;
        $this->_set         = False;
    }
    
    protected function _getFitsimagesSQL($id,$kset,$kband) {
        $sql = "SELECT `set`,`band`,`filename`,`XcutSize`,`YcutSize`,`run` "
                . "FROM `" . MAIN_IMAGES . "`.`" . MAIN_fitsIMAGES . "` "
                . "WHERE `" . MAIN_ID . "` = " . $id . " "
                . "AND `set` IN " . $kset . " "
                . "AND `band` IN " . $kband .";";
        return $sql;
    }
    
}
