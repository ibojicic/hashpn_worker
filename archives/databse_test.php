<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 4/1/2017
 * Time: 8:52 AM
 */
require 'vendor/autoload.php';
require "config/bootEloquent.php";

//$model = new PNImages\Imageset;
//$test = collect($imageset->where('imagestable' ,'ug_vphas')->first());
//var_dump($test->contains('ug_vphas'));

//$model = new PNImages\Pngimagesinfo;

//dd($model->get());


/*
$test = new FetchBrew();
$test->setPngimagesinfo();
$arr = $test->_pngimagesinfo->where('type','rgb')->get();
var_dump($arr->where('name','denis'));
*/

$test = new \Imfetch\FetchBrew();

$test->_setMosaicsPath("vphasplus");

var_dump($test->getMosaicsPath());
