<?php

gc_enable();

if (!isset($passfromMakeSuperThumbs) and ! isset($passfromCronMakePngs)) {
    include_once ("/mnt/gpne/gpne_working/classesv2/class.MysqlDriver.php");
    include_once ("/mnt/gpne/gpne_working/includes/pndb_config.php");
    include_once ("/mnt/gpne/gpne_working/includes/functions.php");
    include_once ("/usr/lib/myphplibs/options_use.php");
    $options = getopt($shortOptions);
}
$mysqldriver = new MysqlDriver($mydbConfig["dbhost_admin"], $mydbConfig["dbuser_admin"], $mydbConfig["dbpass_admin"]);

include_once ("classes/class.FidoBrew.php");
include_once ("classes/class.ParseSpectra.php");

$ParseSpectra = new ParseSpectra($mydbConfig);

include_once("includes/spletch_options.php");

if ($runmosaic) {
    $ParseSpectra->SPECTRA_dbfiller();
    exit();
}

if ($ParseSpectra->parseelcat) {
    foreach ($ParseSpectra->ids as $id) {
        echo "working on " . $id . "...\r";
        $ParseSpectra->parseeELCATData($id);
    }
    exit();

}

foreach ($ParseSpectra->ids as $id) {
    echo "working on " . $id . "...\n";
    $resarray = array();
    $ParseSpectra->setPaths($id);
    $ParseSpectra->setOutTxtFile($id);

    $ParseSpectra->getBasicData($id);
    if ($ParseSpectra->spectradata) {
        foreach ($ParseSpectra->spectradata as $spdata) {
            echo "/data/mashtun/" . pathslash($spdata['path']) . $spdata['fileName']."\n";
            if (is_file("/data/mashtun/" . pathslash($spdata['path']) . $spdata['fileName'])) {
                array_push($resarray, $ParseSpectra->copySpectra($spdata));
            } else
                echo "File is missing...\n";
        }
        $ParseSpectra->setObjectsSpectraFile($id, $resarray);
    }
}

$ParseSpectra->updateSpectraSample();
?>
