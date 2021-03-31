<?php
namespace HashPN\App\Common;

use HashPN\Models\MainGPN\PNMain;
use MyPHP\MyLogger;
use MyPHP\MyStandards;

/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 6/1/2017
 * Time: 2:08 PM
 */
class qObject
{
    use MyStandards;

    public $mylogger;

    private $_idPNMain;
    private $_PNMainTable;

    private $_flagMajDiam;

    private $_MajDiam;
    private $_MinDiam;

    private $_PAdiam;
    private $_MajExt;
    private $_AngDiam;
    private $_AngExt;
    private $_CScoords;
    private $_CS_DRAJ2000;
    private $_CS_DDECJ2000;

    public function __construct($idPNMain)
    {
        //** assigned to dummy logger by default */
        $this->mylogger = new MyLogger(false);

        $this->_setObjectData($idPNMain);

        if (!$this->_setBaseFolder($idPNMain)) {
            $this->mylogger->logMessage("Problem with creating base folder for fits images.",$this,'error');
        }

    }

    public function setMyLogger(MyLogger $myLogger)
    {
        unset($this->mylogger);
        $this->mylogger = $myLogger;
    }


    private function _setObjectData($idPNMain)
    {
        $this->_idPNMain = intval($idPNMain);

        $this->_PNMainTable = PNMain::find($this->_idPNMain);
        $this->_AngDiam = $this->_PNMainTable->tbAngDiam()->where('inUse',1)->first();
        $this->_AngExt = $this->_PNMainTable->tbAngExt()->where('inUse',1)->first();
        $this->_CScoords = $this->_PNMainTable->tbCSCoords()->where('inUse',1)->first();

        $this->_MajDiam = $this->_AngDiam == null ? 0 : $this->_AngDiam->MajDiam;
        $this->_flagMajDiam = $this->_AngDiam == null ? False : $this->_AngDiam->flagMajDiam == null ? False : True;
        //** TODO setter depends on the value of majdiam */
        $this->_MinDiam = $this->_AngDiam == null ? 0 : $this->_AngDiam->MinDiam;
        $this->_PAdiam = $this->_AngDiam == null ? 0 : $this->_AngDiam->PAdiam;

        $this->_MajExt = $this->_AngExt == null ? 0 : $this->_AngExt->MajExt;

        $this->_CS_DRAJ2000 = $this->_CScoords == null ? 0 : $this->_CScoords->CS_DRAJ2000;
        $this->_CS_DDECJ2000 = $this->_CScoords == null ? 0 : $this->_CScoords->CS_DDECJ2000;
    }

    /**
     * creates base folder for fits images if it doesn't exists
     * @param $idPNMain integer id of the objects
     * @return bool
     */
    private function _setBaseFolder($idPNMain)
    {
        $baseFolder = $this->getBasePathFITS($idPNMain);
        if (!is_dir($baseFolder)) {
            return mkdir($baseFolder);
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getIdPNMain()
    {
        return $this->_idPNMain;
    }

    /**
     * @return PNMain
     */
    public function getPNMainTable()
    {
        return $this->_PNMainTable;
    }

    /**
     * @return mixed
     */
    public function getFlagMajDiam()
    {
        return $this->_flagMajDiam;
    }


    /**
     * @return mixed
     */
    public function getMajDiam()
    {
        return $this->_MajDiam;
    }

    /**
     * @return mixed
     */
    public function getMajExt()
    {
        return $this->_MajExt;
    }

    /**
     * @return mixed
     */
    public function getAngDiam()
    {
        return $this->_AngDiam;
    }

    /**
     * @return mixed
     */
    public function getAngExt()
    {
        return $this->_AngExt;
    }

    /**
     * @return mixed
     */
    public function getMinDiam()
    {
        return $this->_MinDiam;
    }

    /**
     * @return mixed
     */
    public function getPAdiam()
    {
        return $this->_PAdiam;
    }

    /**
     * @return mixed
     */
    public function getCS_DRAJ2000()
    {
        return $this->_CS_DRAJ2000;
    }

    /**
     * @return mixed
     */
    public function getCS_DDECJ2000()
    {
        return $this->_CS_DDECJ2000;
    }


}