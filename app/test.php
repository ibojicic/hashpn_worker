<?php

/*
 * Updates PNGs
 */

$basefolder = "gpne_working";

include_once ("/mnt/gpne/".$basefolder."/includes/functions.php");
include_once ("/mnt/gpne/".$basefolder."/includes/pndb_config.php");
include_once("/mnt/gpne/".$basefolder."/classesv2/class.MysqlDriver.php");


$_mysqldriver = new MysqlDriver($mydbConfig["dbhost_admin"],$mydbConfig["dbuser_admin"],$mydbConfig["dbpass_admin"]);

$phpHandler =  (php_sapi_name() == "cli");

$selectsyst = array('all','notset');

/*
if (!isset($argv[1]) or trim($argv[1]) == '' or (!in_array(trim($argv[1]), $selectsyst) and !is_numeric(trim($argv[1]))))
{
	if ($phpHandler) echo "Update all(all) or id(integer) or not set(notset).\n";
	exit();
}
*/
$updatetable = "`".MAIN_DB."`.`".MAIN_TABLE."`";

$where = "";
/*
if (trim($argv[1]) == 'notset')
{
	$where = " WHERE `PNG` IS NULL ";
}
elseif (is_numeric(trim($argv[1])) == "integer")
{
	$where = " WHERE `".MAIN_ID."` = ".$argv[1];
} else {
	$where = $argv[1];
}
*/
$where = "WHERE `PNG` LIKE 'FrBo%' AND `Glon` IS NOT NULL ";

$sql_query = "SELECT `".MAIN_ID."`, `Glon`, `Glat` FROM ".$updatetable." ".$where;
$origin_array = $_mysqldriver->selectquery($sql_query);

$origin_array_old = $_mysqldriver->selectColumn('PNG',$updatetable, "`".MAIN_ID."` NOT IN (SELECT `".MAIN_ID."` FROM ".$updatetable." ".$where.")");



if (!$origin_array or empty ($origin_array)) die ("No results...");

foreach ($origin_array as $origin)
{
    $id = $origin[MAIN_ID];
    $Xcrd = $origin['Glon'];
    $Ycrd = $origin['Glat'];

    $png = calcPNG($Xcrd,$Ycrd,$origin_array_old);

    if ($png)
    {

        $sql_update = "UPDATE $updatetable SET `PNG` = '".$png."' WHERE `".MAIN_ID."` = ".$id;
        $_mysqldriver->query($sql_update);
    }

}


