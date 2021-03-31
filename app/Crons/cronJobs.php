#!/usr/bin/php

<?php
include_once "options_use.php";
include_once ("/mnt/gpne/gpne_working/includes/pndb_config.php");
include_once ("/mnt/gpne/gpne_working/includes/functions.php");
include_once ('/mnt/gpne/gpne_working/classesv2/class.MysqlDriver.php');
include_once ("/mnt/gpne/gpne_working/classesv2/class.ReadTables.php");

//system("export PYTHONPATH /usr/lib/mypylibs/mylibs/:/usr/lib/mypylibs/mydrivers/:/data/ibojicic/Sites/PyLibs/:/usr/lib");
//if (!is_file(CRONFLAG)) exit();
//unlink(CRONFLAG);


$_mysqldriver = new MysqlDriver($mydbConfig["dbhost_admin"], $mydbConfig["dbuser_admin"], $mydbConfig["dbpass_admin"]);
if ($_mysqldriver->select("*", "`" . USERS_DB . "`.`cronJobs`", "`date_start` IS NOT NULL AND `date_exec` IS NULL"))
    die("work in proccess..");
$crons = $_mysqldriver->select("*", "`" . USERS_DB . "`.`cronJobs`", "`date_start` IS NULL AND `date_exec`  IS NULL", "priority", False, "0,1");
if ($crons) {
    foreach ($crons as $cron) {
        updateCronStart($_mysqldriver, $cron['idcronJobs']);
        $inputs = unserialize($cron['parameters']);
        if (call_user_func("cron_" . $cron['cronScript'], $inputs, $_mysqldriver, $mydbConfig))
            updateCronFinished($_mysqldriver, $cron['idcronJobs']);
    }
}

function cron_make_pngs($inputs, $mysqldrive, $mydbConfig) {
    chdir($mydbConfig['makepngsfolder']);
    $passfromCron = True;
    $restore_sql = (isset($inputs['sql_restore']) and $inputs['sql_restore'] != "") ? $inputs['sql_restore'] : False;
    $update_sql = (isset($inputs['sql_update']) and $inputs['sql_update'] != "") ? $inputs['sql_update'] : False;
    $options = $inputs['options'];
    if ($update_sql)
        $mysqldrive->query($update_sql);
    include_once "brew.php";
    //if (!$passfromCronMakePngs and $restore_sql) $mysqldrive->query($restore_sql);
    return true;
}

function cron_download_images($inputs, $mysqldrive, $mydbConfig) {
    $passfromCron = True;
    chdir($mydbConfig['downloadimagesfolder']);
    $options = $inputs['options'];
    include_once "fido.php";
    return true;
}

function cron_checkInUse($inputs, $mysqldriver, $mydbConfig) {
    $passfromCron = True;
    include_once "cronCheckInUse.php";
    return true;
}

function updateCronStart($mysql, $id) {
    $mysql->query("UPDATE `" . USERS_DB . "`.`cronJobs` SET `date_start` = NOW() WHERE `idcronJobs` = $id");
    return True;
}

function updateCronFinished($mysql, $id) {
    $mysql->query("UPDATE `" . USERS_DB . "`.`cronJobs` SET `date_exec` = NOW() WHERE `idcronJobs` = $id");
    return True;
}
?>
