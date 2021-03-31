<?php
namespace HashPN\App\Common;

/**
 * Description of MakePngImage
 *
 * @author ivan
 */
class MakePngImage extends FidoBrew {

    private $_markers = array();
    private $_markersFile;
    private $_majD;
    private $_minD;
    private $_PA;
    private $_imagetypes = array("m" => "n", "t" => "n", "s" => "n", "z" => "n", "o" => "n", "w" => "n");
    private $_redorgbcube = "n";
    private $_extracomm = "";
    private $_fontsize = 'x-small';
    private $_pngcolumns = array();
    private $_fitsimages = False;
    private $_useimages = False;
    private $_imageclrs = array("rgb" => array("R","G","B"),"intensity" => array("in"));
    private $_imagetype = False;
    private $_imlevels = False;
    private $_pythonCommandArray;
    private $_statbox;
    private $_maxstatbox;
    private $_imagesize = False;
    private $_overwright = False;
    private $_tempdir;
    private $_outImage;
    private $_idsArray = array();
    private $_objectdata = array();
    private $_zoutpath = False;
    private $_rgb_cube = False;
    private $_label = "";
    private $_xlabel = 0;
    private $_ylabel = 0;
    private $_fchart = "n";
    private $_fchartmpos = "n";
    private $_fchartmdiam = "n";
    private $_fchartmorien = "n";
    private $_pythonOutput = False;
    
    public $docheck = False;//ok
    public $setsArray = array();//ok
    public $imagesets = array();//ok
    public $deldoimage = False;//ok
    public $maxdiam = False;//ok
    public $updatelevels = False;//ok
    public $outformatmain = "png";//ok
    public $outformatthumb = "jpg";//ok
    public $labelcol = False;

    public function __construct($myConfig, $imageInfoTables) {
        parent::__construct($myConfig, $imageInfoTables);
        $this->fillSurveyData();
        $this->_fillPngImagesCols();
        $this->_getSetsArray();
    }

    public function setZoutFolder($path) {//ok
        $this->_zoutpath = $path;
    }

    private function _getSetsArray() {
        $this->setsArray = array_keys($this->_pngInfoTables);
    }


    private function _getIdsArray() {
        $this->_idsArray = $this->_mysqldriver->selectColumn("`" . MAIN_ID . "`", $this->_mysqldriver->tblName(MAIN_DB,VIEW_TABLE), str_ireplace("WHERE", "" ,$this->_extraselect), "`" . MAIN_ID . "`");
    }

    public function setImageSet($set) { //ok
        if ($set == 'all') {
            $this->imagesets = $this->setsArray;
        } else {
            $this->imagesets = $this->_parseSets($set);
        }
        return $this->imagesets;
    }

    private function _parseSets($set) {
        $result = array();
        $chunks = explode(",", $set);
        foreach ($chunks as $chunk)
            if (isset($this->setsArray[trim($chunk)]))
                array_push($result, $this->setsArray[trim($chunk)]);
        return $result;
    }

    public function setImageSetByName($set) {//ok
        $this->imagesets = array($set);
        return TRUE;
    }

    public function setFontSize($size) { //ok
        $this->_fontsize = $size;
    }

    public function setIds($id) {//ok
        if ($id === 'all') {
            $this->_getIdsArray();
            $this->ids = $this->_idsArray;
        } else
            $this->ids = explode(",", $id);
        return $this->ids;
    }

    /*
    public function setExtraSelect($where = False) {//ok
        if ($where) {
            $this->_extraselect = $this->_extraselect == "" ? $this->_extraselect = " " : $this->_extraselect . " AND ";
            $this->_extraselect .= " " . $where . " ";
        }
    }
     * 
     */

    public function setRedoRgbCubes() {//ok
        $this->_redorgbcube = "y";
    }

    public function setOverwright() {//ok
        $this->_overwright = True;
    }

    public function setOutFormatMain($format) { //ok
        $this->outformatmain = $format;
    }

    public function setOutFormatThumb($format) {//ok
        $this->outformatthumb = $format;
    }

//    public function setTempDir($tempdir = False) {
//        $this->_tempdir = $tempdir ? $tempdir : "/tmp/tmpdir" . rand(100000, 999999) . "/";
//        if (is_dir($this->_tempdir))
//            exec("rm -rf $this->_tempdir");
//        mkdir($this->_tempdir);
//        return $this->_tempdir;
//    }

//    private function _setMarkersFile() {
//        $this->_markersFile = $this->_tempdir . "markrs" . rand(100000, 999999) . ".mrk";
//        return TRUE;
//    }

    public function rmTempDir() { //ok
        if (is_dir($this->_tempdir))
            shell_exec("rm -rf " . $this->_tempdir);
        return;
    }
    
    public function parseLabel($label) {
        $chunks = explode(",", $label);
        if (count($chunks) != 3) return False;
        $this->labelcol = $chunks[0];
        $this->_xlabel = floatval($chunks[1]);
        $this->_ylabel = floatval($chunks[2]);
    }

    public function parseFChart($fchart) {
        $chunks = explode(",", $fchart);
        if (count($chunks) != 3) return False;
        $this->_fchart = "y";
        $this->_fchartmpos = $chunks[0] == "y" ? "y" : "n";
        $this->_fchartmdiam = $chunks[1] == "y" ? "y" : "n";
        $this->_fchartmorien = $chunks[2] == "y" ? "y" : "n";
    }

    private function _setLabel() {
        if ($this->labelcol and isset($this->_objectdata[$this->labelcol])) 
            $this->_label = $this->_objectdata[$this->labelcol];        
    }


//    private function _setOutImageName($run) {
//        $run = $run ? "_r" . $run : "";
//        $this->_outImage = $this->_objectId . $run . "_" . $this->_pngInfoTables[$this->_set]['name_out'];
//    }


    private function _getBasicData() {
        $this->_objectdata = array();
        $sql = "SELECT * FROM `" . MAIN_DB . "`.`" . VIEW_TABLE . "` WHERE `" . MAIN_ID . "` = " .$this->_objectId. ";";
        $result = $this->_mysqldriver->selectquery($sql);
        if (empty($result))
            return False;
        foreach ($result[0] as $key => $val)
            $this->_objectdata[$key] = trim($val) == "" ? False : trim($val);
        return True;
    }
    
//    private function _getFitsImages() {
//        $this->_fitsimages = False;
//        if ($this->_pngInfoTables[$this->_set]["multiple"] == "y") {
//            $kset = $this->_pngInfoTables[$this->_set]["type"] == "rgb" ? $this->_pngInfoTables[$this->_set]["R_srv"] : $this->_pngInfoTables[$this->_set]["in_srv"];
//            $sql = "SELECT '".$kset."' as 'set',`band`,`filename`,`XcutSize`,`YcutSize`,`run` "
//                    . "FROM `".MAIN_IMAGES."`.`".$kset."` WHERE `".MAIN_ID."` = ".$this->_objectId." AND `found` = 'y';";
//        } else {
//            if ($this->_pngInfoTables[$this->_set]["type"] == "rgb") {
//                $kset = "('".$this->_pngInfoTables[$this->_set]["R_srv"]."',"
//                    ."'".$this->_pngInfoTables[$this->_set]["G_srv"]."',"
//                    ."'".$this->_pngInfoTables[$this->_set]["B_srv"]."')";
//                $kband = "('".$this->_pngInfoTables[$this->_set]["R_band"]."',"
//                    ."'".$this->_pngInfoTables[$this->_set]["G_band"]."',"
//                    ."'".$this->_pngInfoTables[$this->_set]["B_band"]."')";
//            } else {
//                $kset  = "('".$this->_pngInfoTables[$this->_set]["in_srv"]."')";
//                $kband  = "('".$this->_pngInfoTables[$this->_set]["in_band"]."')";
//            }
//            $sql = $this->_getFitsimagesSQL($this->_objectId, $kset, $kband);
//        }
//
//        //echo $sql."\n";
//        //exit();
//
//        $result = $this->_mysqldriver->selectquery($sql);
//        if (!empty($result)) $this->_fitsimages = $this->_groupByValue($result);
//        return $this->_fitsimages;
//    }
    
    
    
    /**
     * group arrays by "run" parameter (default -1: if not set or = false convert to -1)
     * @param array $array 
     * @return array grouped by run value
     */
    private function _groupByValue($array) {
        $result = array();
        foreach ($array as $data) {
            $curset = $data['set'];
            $curband = $data['band'];
            $currun = (trim($data['run']) == "" or !isset($data['run']) or !$data['run']) ? -1 : $data['run'];
            unset ($data['set'],$data['band'],$data['run']);
            if (!isset($result[$currun])) $result[$currun] = array();
            if (!isset($result[$currun][$curset])) $result[$currun][$curset] = array();
            $result[$currun][$curset][$curband] = $data;            
        }
        return $result;
    }

//    private function _setDataForMain() {
//        if ($this->RAJ2000 and $this->DECJ2000) {
//            $this->_setMarkers("centroid", $this->RAJ2000, $this->DECJ2000, $this->_pngInfoTables[$this->_set]['centroid_col'], False, False, $this->_PA);
//            if ($this->_pngInfoTables[$this->_set]['resolution'] <= $this->diam)
//                $this->_setMarkers("diameter", $this->RAJ2000, $this->DECJ2000, $this->_pngInfoTables[$this->_set]['centroid_col'], $this->_majD, $this->_minD, $this->_PA);
//        }
//        if ($this->CS_RAJ2000 and $this->CS_DECJ2000)
//            $this->_setMarkers("CS_pos", $this->CS_RAJ2000, $this->CS_DECJ2000, $this->_pngInfoTables[$this->_set]['CS_pos_col']);
//        return TRUE;
//    }

    private function _checkDoneImage() {
        return (is_file($this->_pythonCommandArray['OUT_DIR'] . $this->_pythonCommandArray['OutImage'] . ".png"));
    }

    private function _setDiam($diam = False) {
        $this->diam = $diam ? $diam : isset($this->_objectdata['MajExt']) ? $this->_objectdata['MajExt'] : 0;
        if (trim($this->diam) == '' or floatval($this->diam) != $this->diam)
            $this->diam = 1;
        $this->_majD = trim($this->_objectdata['MajDiam']) == "" ? 1 : $this->_objectdata['MajDiam'];
        $this->_minD = trim($this->_objectdata['MinDiam']) == "" ? False : $this->_objectdata['MinDiam'];
        $this->_PA = trim(isset($this->_objectdata['PAdiam']) and $this->_objectdata['PAdiam']) == "" ? False : $this->_objectdata['PAdiam'];
        $this->diam = $this->diam < $this->_majD ? $this->_majD : $this->diam;
        $this->drawellipse = ($this->_majD and $this->_minD and $this->_PA);
        return;
    }

//    private function _setMarkers($marker, $Xcenter, $Ycenter, $olaycolour, $majAx = False, $minAx = False, $PA = 0.) {
//
//        switch ($marker) {
//            case "centroid":
//                $markerdata = array(
//                    "marker" => $marker,
//                    "Xcenter" => floatval($Xcenter),
//                    "Ycenter" => floatval($Ycenter),
//                    "PADiam" => $PA ? floatval($PA) : 0.,
//                    "olaycol" => $olaycolour
//                );
//                break;
//            case "CS_pos":
//                $markerdata = array(
//                    "marker" => $marker,
//                    "CSXcenter" => floatval($Xcenter),
//                    "CSYcenter" => floatval($Ycenter),
//                    "olaycol" => $olaycolour
//                );
//                break;
//
//            //case "maxext":
//
//            case "diameter":
//                $markerdata = array(
//                    "marker" => $marker,
//                    "Xcenter" => floatval($Xcenter),
//                    "Ycenter" => floatval($Ycenter),
//                    "majDiam" => floatval($majAx),
//                    "minDiam" => ($minAx and $PA) ? floatval($minAx) : floatval($majAx),
//                    "PADiam" => ($PA) ? floatval($PA) : 0.,
//                    "olaycol" => $olaycolour
//                );
//                break;
//
//            default:
//                break;
//        }
//        array_push($this->_markers, $markerdata);
//        return True;
//    }

//    private function _writeMarkers() {
//        $fp = fopen($this->_markersFile, "w");
//
//        foreach ($this->_markers as $marker) {
//            $line = array();
//            foreach ($marker as $key => $val) {
//                $val = (gettype($val) == "string") ? "'" . $val . "'" : $val;
//                array_push($line, "'" . $key . "'," . $val);
//            }
//            fwrite($fp, implode(",", $line) . "\n");
//        }
//        fclose($fp);
//        return True;
//    }

//    private function _setBoxSize($imagesize) {
//        $this->boxsize = 0;
//        foreach (array_keys($this->_pngInfoTables) as $set) {
//            $tmpmin = $this->_getImageSize($set, $imagesize);
//            if ($this->boxsize == 0 or $this->boxsize > $tmpmin)
//                $this->boxsize = $tmpmin;
//        }
//    }

    private function _setImageSize($imageSize) {
        $this->_imagesize = floatval($this->_getImageSize($this->_set,$imageSize));
    }

    private function _getImageSize($set,$imageSize = False) {
        return $imageSize ? $imageSize : getCutoutSize("n", $this->diam, $this->_pngInfoTables[$set]['minimDiam']);
    }

//    private function _setStatBoxSize() {
//        $this->_statbox = floatval($this->diam / 2 < $this->_pngInfoTables[$this->_set]['psf'] ?
//                $this->_pngInfoTables[$this->_set]['psf'] : $this->diam / 2);
//        $this->_maxstatbox = floatval($this->diam < $this->_pngInfoTables[$this->_set]['minimDiam'] ?
//                $this->_pngInfoTables[$this->_set]['minimDiam'] : $this->diam);
//
//    }


//    private function _setFitsImages($rundata) {
//        $this->_useimages = False;
//        if (!$this->_imagetype) $this->_setImageType ();
//        $srvdata = $this->_pngInfoTables[$this->_set];
//        foreach ($this->_imageclrs[$this->_imagetype] as $clr) {
//
//            if (!isset( $rundata[$srvdata[$clr."_srv"]][$srvdata[$clr."_band"]]['filename'])) return False;
//            $this->_useimages[$clr] = $srvdata[$clr."_folder"] . "/" . $rundata[$srvdata[$clr."_srv"]][$srvdata[$clr."_band"]]['filename'];
//        }
//        return True;
//    }


//    /**
//     * set RGB cube name
//     * @param string $set current set
//     * @param int $id current id
//     * @param string $run extra identifier for the multiple rgb cubes
//     * @param string $outpath
//     */
//    private function _setRGBcube($run = False, $outpath = False) {
//        if ($this->_imagetype == "rgb") {
//            $run = $run ? $run . "_" : "";
//            $mainpath = $outpath ? $outpath : RGBCUBES;
//            $this->_rgb_cube = $mainpath . $this->_set . "_" . $run . $this->_objectId . "_rgbcube";
//        } else {
//            $this->_rgb_cube = False;
//        }
//    }

    
    private function _setImageType() {
        $this->_imagetype = $this->_pngInfoTables[$this->_set]['type'];
    }

//    private function _setLevels() {
//        $pngset = $this->_pngInfoTables[$this->_set];
//        @$this->_imlevels["min_r"] = floatval($pngset['min_imLevel']);
//        @$this->_imlevels["max_r"] = floatval($pngset['imLevel']);
//        @$this->_imlevels["min_v"] = floatval($this->_fitsInfoTables[$pngset['in_srv']]['minval']);
//        @$this->_imlevels["max_v"] = floatval($this->_fitsInfoTables[$pngset['in_srv']]['maxval']);
//        @$this->_imlevels["minR_r"] = floatval($pngset['min_r_imLevel']);
//        @$this->_imlevels["minG_r"] = floatval($pngset['min_g_imLevel']);
//        @$this->_imlevels["minB_r"] = floatval($pngset['min_b_imLevel']);
//        @$this->_imlevels["maxR_r"] = floatval($pngset['r_imLevel']);
//        @$this->_imlevels["maxG_r"] = floatval($pngset['g_imLevel']);
//        @$this->_imlevels["maxB_r"] = floatval($pngset['b_imLevel']);
//        @$this->_imlevels["minR_v"] = floatval($this->_fitsInfoTables[$pngset['R_srv']]['minval']);
//        @$this->_imlevels["minG_v"] = floatval($this->_fitsInfoTables[$pngset['G_srv']]['minval']);
//        @$this->_imlevels["minB_v"] = floatval($this->_fitsInfoTables[$pngset['B_srv']]['minval']);
//        @$this->_imlevels["maxR_v"] = floatval($this->_fitsInfoTables[$pngset['R_srv']]['maxval']);
//        @$this->_imlevels["maxG_v"] = floatval($this->_fitsInfoTables[$pngset['G_srv']]['maxval']);
//        @$this->_imlevels["maxB_v"] = floatval($this->_fitsInfoTables[$pngset['B_srv']]['maxval']);
//        @$this->_imlevels["imlev"] = $pngset['imlev'];
//    }

//    private function _setCoords($RAJ2000 = False, $DDECJ2000 = False, $CS_RAJ2000 = False, $CS_DDECJ2000 = False) {
//        $this->RAJ2000 = $RAJ2000 ? $RAJ2000 : $this->_objectdata['DRAJ2000'];
//        $this->DECJ2000 = $DDECJ2000 ? $DDECJ2000 : $this->_objectdata['DDECJ2000'];
//        $this->CS_RAJ2000 = $CS_RAJ2000 ? $CS_RAJ2000 : isset($this->_objectdata['CS_DRAJ2000']) ? $this->_objectdata['CS_DRAJ2000'] : False;
//        $this->CS_DECJ2000 = $CS_DDECJ2000 ? $CS_DDECJ2000 : isset($this->_objectdata['CS_DDECJ2000']) ? $this->_objectdata['CS_DDECJ2000'] : False;
//    }

//    public function setImageOptions($options) { //ok
//        $vals = str_split($options);
//        foreach ($vals as $val)
//            $this->_imagetypes[$val] = 'y';
//    }

//    private function _setPythonCommandArray() {
//        $this->_pythonCommandArray = array(
//            "idPNMain"          => $this->_objectId,
//            "TEMP_DIR"          => $this->_tempdir,
//            "SOURCE_DIR"        => $this->_basepathFITS,
//            "OUT_DIR"           => $this->_outpathPNG,
//            "ZOUT_DIR"          => $this->_zoutpath,
//            "OutImage"          => $this->_outImage,
//            "ZoutImage"         => $this->_outImage,
//            "rgb_cube"          => $this->_rgb_cube,
//            "redorgb"           => $this->_redorgbcube,
//            "DRAJ2000"          => floatval($this->RAJ2000),
//            "DDECJ2000"         => floatval($this->DECJ2000),
//            "CS_DRAJ2000"       => floatval($this->CS_RAJ2000),
//            "CS_DDECJ2000"      => floatval($this->CS_DECJ2000),
//            "MajDiam"           => floatval($this->_majD),
//            "MinDiam"           => floatval($this->_minD),
//            "PA"                => floatval($this->_PA),
//            "ImageSize"         => $this->_imagesize,
//            "BoxSize"           => floatval($this->boxsize),
//            "statbox"           => $this->_statbox,
//            "maxstatbox"        => $this->_maxstatbox,
//            "Markers"           => $this->_markersFile,
//            "Set"               => $this->_set,
//            "DrawBeam"          => $this->_pngInfoTables[$this->_set]['drawbeam'],
//            "extracomm"         => $this->_extracomm, // extra command fror FITScutout
//            "setaxlabsize"      => $this->_fontsize,//"xx-small"
//            "outformatmain"     => $this->outformatmain,
//            "outformatthumb"    => $this->outformatthumb,
//            "fchart"            => $this->_fchart,
//            "fchartmpos"        => $this->_fchartmpos,
//            "fchartmdiam"       => $this->_fchartmdiam,
//            "fchartmorien"      => $this->_fchartmorien,
//            "addlabel"          => $this->_label,
//            "xlabel"            => $this->_xlabel,
//            "ylabel"            => $this->_ylabel,
//            "difflevel"         => $this->_pngInfoTables[$this->_set]['difflevel']
//
//        );
//        $this->_pythonCommandArray = array_merge($this->_pythonCommandArray,  $this->_imlevels, $this->_imagetypes, $this->_useimages);
//
//        //print_r($this->_pythonCommandArray);
//        //exit();
//    }
//


    private function _checkFlags() {
        return (!$this->imageexists or $this->_overwright);
    }

    private function _checkFitsImages() {
        if (!$this->_imagetype) $this->_setImageType ();
        foreach ($this->_imageclrs[$this->_imagetype] as $clr) {
            if (!isset($this->_useimages[$clr]) or !is_file($this->_basepathFITS . $this->_useimages[$clr])) return False;
        }
        return True;
    }


    private function _setImageExistsFlag() {
        $this->imageexists = (is_file($this->_outpathPNG . $this->_outImage . ".png"));
        return $this->imageexists;
    }
    

//    public function runMakePng($set, $imagesize = False) { //ok
//        $this->_setSet($set);
//        $this->_setImageType();
//        $this->_checkextracomm();
//        if (!$this->_getBasicData()) return False;
//        if (!$this->_basepathFITS) $this->_setBasePathFITS();
//        if (!$this->_getFitsImages()) return False;
//        $this->_makeOutPathPNG();
//        $this->_updateLevels();
//        $this->_setLevels();
//        $this->_setCoords();
//        $this->_setDiam();
//        if ($this->maxdiam and $this->maxdiam < $this->diam) return False;
//        $this->_setStatBoxSize();
//        $this->_setBoxSize($imagesize);
//        $this->_setImageSize($imagesize);
//        $this->_setLabel();
//        foreach ($this->_fitsimages as $run => $data) {
//            $this->_setFitsImages($data);
//            if ($this->_checkFitsImages()) {
//
//                $run = $run == "-1" ? False : $run;
//                $this->_setRGBcube($run);
//                if ($this->_overwright and $this->_imagetype == "rgb") $this->_redorgbcube = "y";
//                $this->setTempDir();
//                $this->_setMarkersFile();
//                $this->_setDataForMain();
//                $this->_writeMarkers();
//                $this->_markers = array();
//                $this->_setOutImageName($run);
//                $this->_setImageExistsFlag();
//                if ($this->_checkFlags()) {
//                    $this->_setPythonCommandArray();
//                    if (!$this->docheck) {
//                        if ($this->_imagetype == "rgb") {
//                            $this->_pythonOutput = pythonToPhp("make_rgbs_driver.py",  $this->_pythonCommandArray);
//                        } elseif ($this->_imagetype == "intensity") {
//                            $this->_pythonOutput = pythonToPhp("make_intensities_driver.py",  $this->_pythonCommandArray);
//                        }
//                        if ($this->_pythonOutput and $this->_checkDoneImage()) $this->_recordInDb();
//
//                    }
//                }
//            }
//            $this->rmTempDir();
//        }
//        return True;
//    }

  
    private function _updateLevels() {
        if (!$this->updatelevels)
            return False;
        $levels = $this->_mysqldriver->selectOne("min_imLevel,imLevel,min_r_imLevel,r_imLevel,min_g_imLevel,g_imLevel,min_b_imLevel,b_imLevel", 
                $this->_mysqldriver->tblName(MAIN_IMAGES,"pngimages"), "`name` = '" . $this->_set . "' AND `" . MAIN_ID . "` = " . $this->_objectId);
        if (!$levels)
            return False;
        foreach ($levels as $levkey => $levval)
            $this->_pngInfoTables[$this->_set][$levkey] = $levval;
        return True;
    }

    private function _fillPngImagesCols() {
        $this->_pngcolumns = array();
        $sql = "SHOW COLUMNS FROM `PNImages`.`pngimages`;";
        $res = $this->_mysqldriver->selectquery($sql);
        foreach ($res as $vals)
            if ($vals['Field'] != 'idpngimages' and $vals['Field'] != 'Date')
                array_push($this->_pngcolumns, $vals['Field']);
    }

    private function _recordInDb() {
        if (!$this->recordtodb) return False;
        $recordarray = $this->_pythonOutput;
        $id = $this->_pythonOutput['OutImage'];
        foreach (array_keys($this->_pythonCommandArray) as $key)
            if (!in_array($key, $this->_pngcolumns))
                unset($recordarray[$key]);
        $cols = "`" . implode("`,`", array_keys($recordarray)) . "`";
        $vals = "'" . implode("','", $recordarray) . "'";

        $sqldelete = "DELETE FROM `PNImages`.`pngimages` WHERE `OutImage` = '" . $id . "';";
        $sqlinsert = "INSERT INTO `PNImages`.`pngimages` (" . $cols . ",`Date`) VALUES (" . $vals . ",NOW());";
        $this->_mysqldriver->query($sqldelete);
        $this->_mysqldriver->query($sqlinsert);
        echo "Added " . $id . " to the pnimages...\n";
    }

    private function _checkextracomm() {
        switch ($this->_set) {
            case "msxACE":
            case "msxACD":
            case "msxADE":
            case "msxCDE":
                $this->_extracomm = "msxcheckoffset";
                break;
        }
    }

}
 
