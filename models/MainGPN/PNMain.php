<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:22:38 +0000.
 */
namespace HashPN\Models\MainGPN;

use HashPN\Models\MainPNUsers\accesslog;
use HashPN\Models\MainPNUsers\cronJobs;
use HashPN\Models\MainPNUsers\userslist;
use HashPN\Models\PNImages\sss;
use Illuminate\Database\Eloquent\Model as Eloquent;
use HashPN\Models\PNImages\bolocam;
use HashPN\Models\PNImages\cornish;
use HashPN\Models\PNImages\denis;
use HashPN\Models\PNImages\fitsimages;
use HashPN\Models\PNImages\galex;
use HashPN\Models\PNImages\galex_G;
use HashPN\Models\PNImages\glimpse_full;
use HashPN\Models\PNImages\gps;
use HashPN\Models\PNImages\iphas;
use HashPN\Models\PNImages\iquot_HaSr;
use HashPN\Models\PNImages\iras;
use HashPN\Models\PNImages\lmc_mcels;
use HashPN\Models\PNImages\mgps2;
use HashPN\Models\PNImages\mips24;
use HashPN\Models\PNImages\mips70;
use HashPN\Models\PNImages\msx;
use HashPN\Models\PNImages\nvas;
use HashPN\Models\PNImages\nvss;
use HashPN\Models\PNImages\pmn;
use HashPN\Models\PNImages\pngimages;
use HashPN\Models\PNImages\popiplan_eso;
use HashPN\Models\PNImages\quot_HaSr;
use HashPN\Models\PNImages\radiomash;
use HashPN\Models\PNImages\sage_irac;
use HashPN\Models\PNImages\sdss;
use HashPN\Models\PNImages\shassa;
use HashPN\Models\PNImages\shs;
use HashPN\Models\PNImages\shs_blckdwn;
use HashPN\Models\PNImages\shs_mc;
use HashPN\Models\PNImages\spitzer_target;
use HashPN\Models\PNImages\subtr_HaSr_shs;
use HashPN\Models\PNImages\twomass;
use HashPN\Models\PNImages\ug_vphas;
use HashPN\Models\PNImages\ukidss;
use HashPN\Models\PNImages\uwish2;
use HashPN\Models\PNImages\vlss;
use HashPN\Models\PNImages\vphasplus;
use HashPN\Models\PNImages\vquot_HaSr;
use HashPN\Models\PNImages\vtss;
use HashPN\Models\PNImages\vvve;
use HashPN\Models\PNImages\weidmann_2016;
use HashPN\Models\PNImages\wfi;
use HashPN\Models\PNImages\wise;

/**
 * Class PNMain
 *
 * @property int $idPNMain
 * @property string $PNG
 * @property string $refPNG
 * @property string $RAJ2000
 * @property string $DECJ2000
 * @property float $DRAJ2000
 * @property float $DDECJ2000
 * @property float $Glon
 * @property float $Glat
 * @property string $refCoord
 * @property string $Catalogue
 * @property string $refCatalogue
 * @property string $userRecord
 * @property string $domain
 * @property string $refDomain
 * @property string $PNstat
 * @property string $refPNstat
 * @property string $SimbadID
 * @property string $refSimbadID
 * @property string $show
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $temp_id
 *
 * @property ReferenceIDs $ReferenceIDs
 * @property objStatus $objStatus
 * @property userslist $userslist
 * @property \Illuminate\Database\Eloquent\Collection $tb_ang_diams
 * @property \Illuminate\Database\Eloquent\Collection $tbAngExt
 * @property \Illuminate\Database\Eloquent\Collection $tbCName
 * @property \Illuminate\Database\Eloquent\Collection $tbCSCoord
 * @property \Illuminate\Database\Eloquent\Collection $tbHrvel
 * @property \Illuminate\Database\Eloquent\Collection $tbIRFluxes
 * @property \Illuminate\Database\Eloquent\Collection $tbIRMag
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection $tbPNMorph
 * @property \Illuminate\Database\Eloquent\Collection $p_n_main_tb_radio_conts
 * @property \Illuminate\Database\Eloquent\Collection $tblogFHalpha
 * @property \Illuminate\Database\Eloquent\Collection $tblogFOIII
 * @property \Illuminate\Database\Eloquent\Collection $tbPA
 * @property \Illuminate\Database\Eloquent\Collection $tbRadioCont
 * @property \Illuminate\Database\Eloquent\Collection $tb_usr_comms
 * @property \Illuminate\Database\Eloquent\Collection $accesslogs
 * @property \Illuminate\Database\Eloquent\Collection $cronJobs
 * @property \Illuminate\Database\Eloquent\Collection $2masses
 * @property \Illuminate\Database\Eloquent\Collection $bolocams
 * @property \Illuminate\Database\Eloquent\Collection $cornishes
 * @property \Illuminate\Database\Eloquent\Collection $denis
 * @property \Illuminate\Database\Eloquent\Collection $fitsimages
 * @property \Illuminate\Database\Eloquent\Collection $galexes
 * @property \Illuminate\Database\Eloquent\Collection $galex__gs
 * @property \Illuminate\Database\Eloquent\Collection $glimpse_fulls
 * @property \Illuminate\Database\Eloquent\Collection $gps
 * @property \Illuminate\Database\Eloquent\Collection $iphas
 * @property \Illuminate\Database\Eloquent\Collection $iquot__ha_srs
 * @property \Illuminate\Database\Eloquent\Collection $iras
 * @property \Illuminate\Database\Eloquent\Collection $lmc_mcels
 * @property \Illuminate\Database\Eloquent\Collection $mgps2s
 * @property \Illuminate\Database\Eloquent\Collection $mips24s
 * @property \Illuminate\Database\Eloquent\Collection $mips70s
 * @property \Illuminate\Database\Eloquent\Collection $msxes
 * @property \Illuminate\Database\Eloquent\Collection $nvas
 * @property \Illuminate\Database\Eloquent\Collection $nvsses
 * @property \Illuminate\Database\Eloquent\Collection $pmns
 * @property \Illuminate\Database\Eloquent\Collection $pngimages
 * @property \Illuminate\Database\Eloquent\Collection $popiplan_esos
 * @property \Illuminate\Database\Eloquent\Collection $quot__ha_srs
 * @property \Illuminate\Database\Eloquent\Collection $radiomashes
 * @property \Illuminate\Database\Eloquent\Collection $sage_iracs
 * @property \Illuminate\Database\Eloquent\Collection $sdsses
 * @property \Illuminate\Database\Eloquent\Collection $shassas
 * @property \Illuminate\Database\Eloquent\Collection $shes
 * @property \Illuminate\Database\Eloquent\Collection $shs_blckdwns
 * @property \Illuminate\Database\Eloquent\Collection $shs_mcs
 * @property \Illuminate\Database\Eloquent\Collection $spitzer_targets
 * @property \Illuminate\Database\Eloquent\Collection $ssses
 * @property \Illuminate\Database\Eloquent\Collection $subtr__ha_sr_shes
 * @property \Illuminate\Database\Eloquent\Collection $ug_vphas
 * @property \Illuminate\Database\Eloquent\Collection $ukidsses
 * @property \Illuminate\Database\Eloquent\Collection $uwish2s
 * @property \Illuminate\Database\Eloquent\Collection $vlsses
 * @property \Illuminate\Database\Eloquent\Collection $vphaspluses
 * @property \Illuminate\Database\Eloquent\Collection $vquot__ha_srs
 * @property \Illuminate\Database\Eloquent\Collection $vtsses
 * @property \Illuminate\Database\Eloquent\Collection $vvves
 * @property \Illuminate\Database\Eloquent\Collection $weidmann_2016s
 * @property \Illuminate\Database\Eloquent\Collection $wfis
 * @property \Illuminate\Database\Eloquent\Collection $wises
 *

 */
class PNMain extends Eloquent
{
    protected $table = 'PNMain';
    protected $primaryKey = 'idPNMain';
    public $timestamps = true;
    protected $connection = "MainGPN";


    protected $casts = [
        'DRAJ2000' => 'float',
        'DDECJ2000' => 'float',
        'Glon' => 'float',
        'Glat' => 'float'
    ];

    protected $fillable = [
        'PNG',
        'refPNG',
        'RAJ2000',
        'DECJ2000',
        'DRAJ2000',
        'DDECJ2000',
        'Glon',
        'Glat',
        'refCoord',
        'Catalogue',
        'refCatalogue',
        'userRecord',
        'domain',
        'refDomain',
        'PNstat',
        'refPNstat',
        'SimbadID',
        'refSimbadID',
        'show',
        'created_at',
        'updated_at',
        'temp_flag'
    ];


    public function reference_id()
    {
        return $this->belongsTo(ReferenceIDs::class, 'refCoord', 'Identifier');
    }

    public function objStatus()
    {
        return $this->belongsTo(objStatus::class, 'PNstat', 'statusId');
    }

    public function userslist()
    {
        return $this->belongsTo(userslist::class, 'userRecord', 'userName');
    }

    public function tbAngDiam()
    {
        return $this->hasMany(tbAngDiam::class, 'idPNMain');
    }

    public function tbAngExt()
    {
        return $this->hasMany(tbAngExt::class, 'idPNMain');
    }

    public function tmCName()
    {
        return $this->hasMany(tbCName::class, 'idPNMain');
    }

    public function tbCSCoords()
    {
        return $this->hasMany(tbCSCoords::class, 'idPNMain');
    }

    public function tbHrvel()
    {
        return $this->hasMany(tbHrvel::class, 'idPNMain');
    }

    public function tbIRFlux()
    {
        return $this->hasMany(tbIRFlux::class, 'idPNMain');
    }

    public function tbIRMag()
    {
        return $this->hasMany(tbIRMag::class, 'idPNMain');
    }

    public function PNMain_tbPA()
    {
        return $this->hasOne(PNMain_tbPA::class, 'idPNMain');
    }

    public function tbPNMorph()
    {
        return $this->hasMany(tbPNMorph::class, 'idPNMain');
    }

    public function PNMain_tbRadioCont()
    {
        return $this->hasMany(PNMain_tbRadioCont::class, 'idPNMain');
    }

    public function tblogFHalpha()
    {
        return $this->hasMany(tblogFHalpha::class, 'idPNMain');
    }

    public function tblogFOIII()
    {
        return $this->hasMany(tblogFOIII::class, 'idPNMain');
    }

    public function tbPA()
    {
        return $this->hasMany(tbPA::class, 'idPNMain');
    }

    public function tbRadioCont()
    {
        return $this->hasMany(tbRadioCont::class, 'idPNMain');
    }

    public function tbUsrComm()
    {
        return $this->hasMany(tbUsrComm::class, 'idPNMain');
    }

    public function accesslogs()
    {
        return $this->hasMany(accesslog::class, 'idPNMain');
    }

    public function cronJobs()
    {
        return $this->hasMany(cronJobs::class, 'idPNMain');
    }

    public function twomass()//2masses()
    {
        return $this->hasMany(twomass::class, 'idPNMain');
    }

    public function bolocam()
    {
        return $this->hasMany(bolocam::class, 'idPNMain');
    }

    public function cornish()
    {
        return $this->hasMany(cornish::class, 'idPNMain');
    }

    public function denis()
    {
        return $this->hasMany(denis::class, 'idPNMain');
    }

    public function fitsimages()
    {
        return $this->hasMany(fitsimages::class, 'idPNMain');
    }

    public function galex()
    {
        return $this->hasMany(galex::class, 'idPNMain');
    }

    public function galex_g()
    {
        return $this->hasMany(galex_G::class, 'idPNMain');
    }

    public function glimpse_full()
    {
        return $this->hasMany(glimpse_full::class, 'idPNMain');
    }

    public function gps()
    {
        return $this->hasMany(gps::class, 'idPNMain');
    }

    public function iphas()
    {
        return $this->hasMany(iphas::class, 'idPNMain');
    }

    public function iquot_HaSr()
    {
        return $this->hasMany(iquot_HaSr::class, 'idPNMain');
    }

    public function iras()
    {
        return $this->hasMany(iras::class, 'idPNMain');
    }

    public function lmc_mcels()
    {
        return $this->hasMany(lmc_mcels::class, 'idPNMain');
    }

    public function mgps2()
    {
        return $this->hasMany(mgps2::class, 'idPNMain');
    }

    public function mips24()
    {
        return $this->hasMany(mips24::class, 'idPNMain');
    }

    public function mips70()
    {
        return $this->hasMany(mips70::class, 'idPNMain');
    }

    public function msx()
    {
        return $this->hasMany(msx::class, 'idPNMain');
    }

    public function nvas()
    {
        return $this->hasMany(nvas::class, 'idPNMain');
    }

    public function nvss()
    {
        return $this->hasMany(nvss::class, 'idPNMain');
    }

    public function pmn()
    {
        return $this->hasMany(pmn::class, 'idPNMain');
    }

    public function pngimages()
    {
        return $this->hasMany(pngimages::class, 'idPNMain');
    }

    public function popiplan_eso()
    {
        return $this->hasMany(popiplan_eso::class, 'idPNMain');
    }

    public function quot_HaSr()
    {
        return $this->hasMany(quot_HaSr::class, 'idPNMain');
    }

    public function radiomash()
    {
        return $this->hasMany(radiomash::class, 'idPNMain');
    }

    public function sage_irac()
    {
        return $this->hasMany(sage_irac::class, 'idPNMain');
    }

    public function sdss()
    {
        return $this->hasMany(sdss::class, 'idPNMain');
    }

    public function shassa()
    {
        return $this->hasMany(shassa::class, 'idPNMain');
    }

    public function shs()
    {
        return $this->hasMany(shs::class, 'idPNMain');
    }

    public function shs_blckdwn()
    {
        return $this->hasMany(shs_blckdwn::class, 'idPNMain');
    }

    public function shs_mc()
    {
        return $this->hasMany(shs_mc::class, 'idPNMain');
    }

    public function spitzer_target()
    {
        return $this->hasMany(spitzer_target::class, 'idPNMain');
    }

    public function sss()
    {
        return $this->hasMany(sss::class, 'idPNMain');
    }

    public function subtr_HaSr_shs()
    {
        return $this->hasMany(subtr_HaSr_shs::class, 'idPNMain');
    }

    public function ug_vphas()
    {
        return $this->hasMany(ug_vphas::class, 'idPNMain');
    }

    public function ukidss()
    {
        return $this->hasMany(ukidss::class, 'idPNMain');
    }

    public function uwish2()
    {
        return $this->hasMany(uwish2::class, 'idPNMain');
    }

    public function vlss()
    {
        return $this->hasMany(vlss::class, 'idPNMain');
    }

    public function vphasplus()
    {
        return $this->hasMany(vphasplus::class, 'idPNMain');
    }

    public function vquot_HaSr()
    {
        return $this->hasMany(vquot_HaSr::class, 'idPNMain');
    }

    public function vtss()
    {
        return $this->hasMany(vtss::class, 'idPNMain');
    }

    public function vvve()
    {
        return $this->hasMany(vvve::class, 'idPNMain');
    }

    public function weidmann_2016()
    {
        return $this->hasMany(weidmann_2016::class, 'idPNMain');
    }

    public function wfi()
    {
        return $this->hasMany(wfi::class, 'idPNMain');
    }

    public function wise()
    {
        return $this->hasMany(wise::class, 'idPNMain');
    }

    /**
     * Find nearby objects in the PNMain table
     * @param $DRAJ2000 float
     * @param $DDECJ2000 float
     * @param $radius float radius in arcdeg
     * @param float $limit number of objects to return
     * @return mixed objects from PNMain including distance field (_r) in arcsec
     */
    public function nearbyObject($DRAJ2000,$DDECJ2000,$radius,$limit = 1E6)
    {
        $rawSQL = "DEGREES(ACOS(SIN(RADIANS(DDECJ2000)) * SIN(RADIANS(".$DDECJ2000.")) + COS(RADIANS(".$DDECJ2000.")) * COS(RADIANS(DDECJ2000)) * COS(RADIANS(DRAJ2000-".$DRAJ2000."))))";
        $result = $this->whereRaw($rawSQL . "<" . $radius)
            ->orderByRaw($rawSQL . " ASC")
            ->get()
            ->take($limit)
            ->toArray();
        $tmpresult = $result;
        foreach ($tmpresult as $key => $item) {
            $result[$key]['_r'] = round(3600 * rad2deg(acos(sin(deg2rad($item['DDECJ2000'])) * sin(deg2rad($DDECJ2000)) + cos(deg2rad($DDECJ2000)) * cos(deg2rad($item['DDECJ2000'])) *
                cos(deg2rad($item['DRAJ2000']-$DRAJ2000)))));
        }
        return $result;
    }
}
