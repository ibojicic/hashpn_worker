<?php

if (!isset($passfromCron)) {
    include_once "/var/www/html/gpne/classesv2/class.MysqlDriver.php";
    $mysqldriver = new MysqlDriver($mydbConfig["dbhost_admin"], $mydbConfig["dbuser_admin"], $mydbConfig["dbpass_admin"]);
}

$list = $mysqldriver->selectquery("SELECT DISTINCT(`varTable`),`bandmapped`,`band` FROM MainGPN.tablesInfo "
        . "WHERE `varTable` <> 'PNMain' AND `varTable` <> 'tbUsrComm';");

$line = "";
foreach ($list as $tbl) {
    if ($tbl['bandmapped'] == 'n') {
        $sql = "SELECT `idPNMain` FROM `" . MAIN_DB . "`.`" . $tbl['varTable'] . "` "
                . "WHERE `InUse` = 1 "
                . "GROUP BY `idPNMain` HAVING COUNT(`idPNMain`) > 1";
        $res = $mysqldriver->selectquery($sql);
        if ($res) {
            foreach ($res as $id) {
                $line .= "Table " . $tbl['varTable'] . ", id = " . $id['idPNMain'] . "\n";
            }
        }
    } else {
        $sql = "SELECT `idPNMain` FROM `" . MAIN_DB . "`.`" . $tbl['varTable'] . "` "
                . "WHERE `InUse` = 1 AND `band` = '" . $tbl['band'] . "' "
                . "GROUP BY `idPNMain` HAVING COUNT(`idPNMain`) > 1";
        $res = $mysqldriver->selectquery($sql);
        if ($res) {
            foreach ($res as $id)
                $line .= "Table " . $tbl['varTable'] . ", band = " . $tbl['band'] . ", id = " . $id['idPNMain'] . "\n";
        }
    }
}
if ($line != "")
    mail("ibojicic@hku.hk", "InUse duplicates", $line);
?>
