<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 5/1/2017
 * Time: 10:59 AM
 */
use Illuminate\Database\Capsule\Manager as Capsule;


$DbSchemas = array(
    "PNImages" => array(
        'driver' => 'mysql',
        'host' => 'niksicko',
        'database' => 'PNImages',
        'username' => 'gpneadmin',
        'password' => '(g.pne.admin)',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ),
    "ImagesSources" => array(
        'driver' => 'mysql',
        'host' => 'niksicko',
        'database' => 'ImagesSources',
        'username' => 'gpneadmin',
        'password' => '(g.pne.admin)',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ),
    "MainGPN" => array(
        'driver' => 'mysql',
        'host' => 'niksicko',
        'database' => 'MainGPN',
        'username' => 'gpneadmin',
        'password' => '(g.pne.admin)',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ),
    "MainPNUsers" => array(
        'driver' => 'mysql',
        'host' => 'niksicko',
        'database' => 'MainPNUsers',
        'username' => 'gpneadmin',
        'password' => '(g.pne.admin)',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ),
    "PNSpectra_Sources" => array(
        'driver' => 'mysql',
        'host' => 'niksicko',
        'database' => 'PNSpectra_Sources',
        'username' => 'gpneadmin',
        'password' => '(g.pne.admin)',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ),
    "MainPNData" => array(
        'driver' => 'mysql',
        'host' => 'niksicko',
        'database' => 'MainPNData',
        'username' => 'gpneadmin',
        'password' => '(g.pne.admin)',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    )

);



$capsule = new Capsule;

/* template $sqlsrv
$sqlsrv = array(
    'driver' => 'mysql',
    'host' => 'niksicko',
    'database' => 'TEST',
    'username' => 'gpneuser',
    'password' => '(g.pne.user)',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
);
*/
foreach ($DbSchemas as $Schema => $SchemaData) {
    $capsule->addConnection($SchemaData,$Schema);
}

$capsule->setAsGlobal();

$capsule->bootEloquent();
