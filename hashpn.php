#! /usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 7/1/2017
 * Time: 1:45 PM
 */

/** TEMPORARY CONSTANTS */

define('MODEL_NAMESPACE','HashPN');

require 'vendor/autoload.php';
require "config/bootEloquent.php";

use \Symfony\Component\Console\Application;

$app = new Application('HASH PN Database support tools.','1.1');

//$app->add(new Imfetch\Commands\FieldsFill());
$app->add(new \HashPN\App\Console\fetch());
$app->add(new \HashPN\App\Console\spetch());
$app->add(new \HashPN\App\Console\info());
$app->add(new \HashPN\App\Console\TestStyles());
$app->add(new \HashPN\App\Console\fetched());
$app->add(new \HashPN\App\Console\insertobjects());
$app->add(new \HashPN\App\Console\brew());
$app->add(new \HashPN\App\Console\fcharts());
$app->add(new \HashPN\App\Console\mysqlbackup());
$app->add(new \HashPN\App\Crons\cronjobs());
$app->add(new \HashPN\App\Crons\checkinuse());

$app->run();