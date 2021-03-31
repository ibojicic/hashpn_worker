<?php
$basefolder = "gpne";
$outfolder = "/disks/kosmos/data1/DATA/MASHSERVER/KOSMOS/SOURCES/PARTIAL_DATASETS/HLA_SPECTRA/";

include_once "/var/www/html/gpne_working/includes/pndb_config.php";
include_once ("/var/www/html/gpne_working/includes/functions.php");

include_once "/var/www/html/gpne_working/classesv2/class.MysqlDriver.php";
include_once ("/var/www/html/gpne_working/classesv2/class.SetMainObjects.php");

$insertkeys = "`FileUpload`,`Preview`,`TargetName`,`RA`,`Dec`,`ExposureTime`,`Archive`,`Instrument`,`Detector`,
`FilterGrismPrism`,`DataType`,`MemerNumber`,`DatasetName`,`ReleaseDate`,`ObservationDate`,`ScienceType`,`Availability`,
`RawFlag`,`Calibrated`,`PreviewFlag`,`Version`,`TargetDescription`,`RA(deg)`,`Dec(deg)`,`GalacticLatitude`,`GalacticLongitude`,
`EclipticLatitude`,`EclipticLongitude`,`PixelScale`,`SpatialResolution`,`SlewingTelescope`,`CD_11`,`CD_12`,`CD_21`,`CD_22`,
`TelescopePosAngle`,`WaveCentral`,`WaveBandwith`,`WaveMinimum`,`WaveMaximum`,`WaveScale`,`OpticalElType`,`OrigElGrismPrism`,
`FiltrGrismPrismNick`,`OtherType`,`SpectralResolution`,`ResolvingPower`,`WavOfSpResPow`,`TimeStart`,`TimeEnd`,`PIName`,`ProposalID`,
`ProposalTitle`,`NumberOfArtifacts`,`ScienceExtension`,`MainFITSFileExt`,`FITSExtList`,`PhotometryMode`,`CombinedType`,
`ID`,`SearchByID`,`SearchByDRAJ2000`,`SearchByDDECJ2000`,`SearchByRad`,`comments`,`idPNMain`,`date`";


//$extensions = array('SX1','X1D');//TRL','FLT','SX1','SX2','CRJ','ASN');


$mysqldriver = new MysqlDriver($mydbConfig["dbhost_admin"],$mydbConfig["dbuser_admin"],$mydbConfig["dbpass_admin"]);

if (isset($useID)) {
    $list = $mysqldriver->select("`idPNMain`,`SimbadID`,`MajDiam`,`RAJ2000`,`DECJ2000`,`DRAJ2000`,`DDECJ2000`", 
        "`".MAIN_DB."`.`".VIEW_TABLE."`","`".MAIN_ID."` = ".$useID);
} else {
    $list = $mysqldriver->select("`idPNMain`,`SimbadID`,`MajDiam`,`RAJ2000`,`DECJ2000`,`DRAJ2000`,`DDECJ2000`", 
        "`".MAIN_DB."`.`".VIEW_TABLE."`");
    }



foreach ($list as $object) {
    sleep(2);
    $searchCoords = "";
    $searchRad = "";
    $searchID = trim($object['SimbadID']) != "" ? trim($object['SimbadID']) : "";
    $searchCoords = $object['RAJ2000'] . " " . $object['DECJ2000'];
    $searchRad = ($object['MajDiam'] != "" and $object['MajDiam'] > 60) ? $object['MajDiam'] : 60;    
    $searchRad = setsearchrad($searchRad);
    
    
    echo "Working on: id=".$object['idPNMain']." Simbad Name=".$searchID."\n";
    
    $url = "http://archives.esac.esa.int/hst/cgi-bin/wdb/wdb/hst/hst_meta_science_votable/query?";
    $parameters = array(
        "votable_out_mode"  => "on",
        "max_rows_returned" => "1000",
        "filt_flag"         => "N",
        "availability"      => "available",
        "members"           => "no",
        "target_name"       => $searchID,
        "c_opt_type"        => "%",
        "is_type"           => "%",
        "search_box"        => $searchRad,
        //"release_date"      => ">1999-02-01",
        "instrument"        => "%"  
    );
    
    
    $parameters["target_name"] = "";
    $parameters["coord"] = $searchCoords;
    $query = $url . str_ireplace('+','%20',http_build_query($parameters))."&archive=HST&archive=HLA&archive=HLS";
    $data = searchHLAGrism($query);

    fillupData($insertkeys, $data, "", $object['DRAJ2000'],$object['DDECJ2000'],$object['MajDiam'],$object['idPNMain'], $mysqldriver);
    $oneDspectra = $mysqldriver->select("*",$this->_mysqldriver->tblName(MAIN_DB_DATA,"HLAGrism_data"),"`idPNMain` = ".$object['idPNMain']." "
            . "AND `DataType` = '1D spectroscopy' AND `download_made` = 'n';");
    if ($oneDspectra and !empty($oneDspectra)) {
        foreach ($oneDspectra as $spectra) {
            $fileprefix = $spectra['DatasetName'];
            $ext = $spectra['ScienceExtension'];
            $fileurl = "http://archives.esac.esa.int/hst/proxy?GZIPPED&file_id=" . $fileprefix;
            if (!is_file($outfolder . $fileprefix . "_" . $ext . ".fits") and ! is_file($outfolder . $fileprefix . "_" . $ext . ".fits.gz")) {
                $command = "wget -O " . $outfolder . $fileprefix . "_" . $ext . ".fits.gz '" . $fileurl . "_" . $ext . "'";
                system($command);
            }

            $command = "gunzip " . $outfolder . $fileprefix . "_" . $ext . ".fits.gz";
            system($command);

            if (is_file($outfolder . $fileprefix . "_" . $ext . ".fits.gz")) {
                $command = "rm " . $outfolder . $fileprefix . "_" . $ext . ".fits.gz";
                system($command);
            }

            if (is_file($outfolder . $fileprefix . "_" . $ext . ".fits")) {
                $update = "UPDATE `" . MAIN_DB_DATA . "`.`HLAGrism_data` SET 
                            `download_attempt` = 'y', `download_made` = 'y', `download_date` = NOW(),
                            `download_data` = '" . $fileprefix . "_" . $ext . ".fits' 
                            WHERE `DatasetName` = '" . $fileprefix . "' and `download_made` = 'n';";
            } else {
                $update = "UPDATE `" . MAIN_DB_DATA . "`.`HLAGrism_data` SET 
                            `download_attempt` = 'y', `download_date` = NOW() 
                            WHERE `DatasetName` = '" . $fileprefix . "' and `download_made` = 'n';";
            }
            $mysqldriver->query($update);
        }
    }
}

function fillupData($insertkeys,$datarray,$searchID,$dra,$ddec,$searchbox,$mainid,$mysqldriver)
{
    foreach ($datarray as $inparray) {
        $insert = "INSERT IGNORE INTO `".MAIN_DB_DATA."`.`HLAGrism_data`
            (".$insertkeys.") VALUES ('" .
            (implode("','",$inparray)).
            "','".$searchID."',".$dra.",".$ddec.",".$searchbox.",''," .
            $mainid.",CURDATE()) ;";
        $mysqldriver->query($insert);
    }
}

function searchHLAGrism($query) {
    $insertkeysarray = array(
        "FileUpload","Preview","TargetName","RA","Dec","ExposureTime","Archive","Instrument","Detector",
        "FilterGrismPrism","DataType","MemerNumber","DatasetName","ReleaseDate","ObservationDate","ScienceType","Availability",
        "RawFlag","Calibrated","PreviewFlag","Version","TargetDescription","RA(deg)","Dec(deg)","GalacticLatitude","GalacticLongitude",
        "EclipticLatitude","EclipticLongitude","PixelScale","SpatialResolution","SlewingTelescope","CD_11","CD_12","CD_21","CD_22",
        "TelescopePosAngle","WaveCentral","WaveBandwith","WaveMinimum","WaveMaximum","WaveScale","OpticalElType","OrigElGrismPrism",
        "FiltrGrismPrismNick","OtherType","SpectralResolution","ResolvingPower","WavOfSpResPow","TimeStart","TimeEnd","PIName","ProposalID",
        "ProposalTitle","NumberOfArtifacts","ScienceExtension","MainFITSFileExt","FITSExtList","PhotometryMode","CombinedType",
        "ID");
    $result = array();
    $contents = file_get_contents($query);
    $outfile = "/tmp/hlagrismresult".genRandomString().".csv";
    $fp = fopen($outfile, "w");
    fwrite($fp, $contents);
    fclose($fp);
    $tmpresults = xml2array($outfile);
    if ((!isset($tmpresults['VOTABLE']['RESOURCE']['INFO_attr']['value']) 
            or $tmpresults['VOTABLE']['RESOURCE']['INFO_attr']['value'] != 'ERROR')
            and (isset($tmpresults['VOTABLE']['RESOURCE']['TABLE']['DATA']['TABLEDATA'])
            and !empty($tmpresults['VOTABLE']['RESOURCE']['TABLE']['DATA']['TABLEDATA']))) {

        echo "Found data.....\n";
        $dataarray = $tmpresults['VOTABLE']['RESOURCE']['TABLE']['DATA']['TABLEDATA']['TR'];
        foreach ($dataarray as $data)
        {
            if (isset($data['TD']) AND is_array($data['TD'])) {
                $inparray = $data['TD'];
                $tmparray = $inparray;
                foreach ($tmparray as $key=>$val) {
                    if (is_array($val)) $inparray[$key] = (empty($val)) ? '' : serialize ($val);
                    $inparray[$key] = mysql_escape_string($inparray[$key]);
                }
                $inpresult = array_combine($insertkeysarray, $inparray);
                array_push($result, $inpresult);
 
            }
        }
        
    }
    return $result;
}

function setsearchrad($diam) {
    $diam = $diam < 30 ? 30 : $diam;
    $deg = floor($diam/3600);
    $min = floor(($diam/3600 - $deg) * 60);
    $sec = floor($diam - $deg*3600 - $min*60);
    
    return $deg.":".$min.":".$sec;
    
}

?>
