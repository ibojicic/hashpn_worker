<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 19/2/2017
 * Time: 2:47 PM
 */

namespace HashPN\App\Common;


use HashPN\Models\PNImages\pngimagesinfo;
use MyPHP\MyLogger;

class PNGMenu
{

    public function __construct($name)
    {
        //** assigned to dummy logger by default */
        $this->mylogger = new MyLogger(false);

        $this->setImageParameters($name);

        $this->setColours($this->getImageParams('type'));
    }

    /**
     * @var array $_colours
     */
    protected $_colours;

    /**
     * @param $type string rgb/intensity
     */
    public function setColours($type)
    {
        $base = [
            'rgb' => ['R', 'G', 'B'],
            'intensity'  => ['in']
        ];
        $this->_colours = $base[$type];
    }

    /**
     * @return array
     */
    public function getColours()
    {
        return $this->_colours;
    }


    /**
     * @var MyLogger $mylogger
     */
    public $mylogger;


    /**
     * @param MyLogger $mylogger
     */
    public function setMylogger($mylogger)
    {
        $this->mylogger = $mylogger;
    }

    /**
     * @var pngimagesinfo $_imageParameters
     */
    private $_imageParameters;

    /**
     * @return mixed
     */
    public function getImageParameters()
    {
        return $this->_imageParameters;
    }

    /**
     * @param $name string
     */
    public function setImageParameters($name)
    {
        $this->_imageParameters = pngimagesinfo::where('name',$name)->first();
    }

    /**
     * Returns values from imagesets table for the set survey
     * @param bool|string $parameter to be returned, if False return the whole model
     * @return mixed
     */
    public function getImageParams($parameter = False)
    {
        if (!$parameter) {
            return $this->_imageParameters;
        }
        if ($this->_imageParameters->{$parameter} === null) {
            return $this->mylogger->logMessage("Value for $parameter is not set (=NULL).",$this,'warning',false);
        }
        return $this->_imageParameters->{$parameter};

    }



}