<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 11:37:59 +0000.
 */

namespace HashPN\Models\ImagesSources;

use HashPN\Models\MainGPN\tbAngDiam;
use HashPN\Models\MainGPN\tbHrvel;
use HashPN\Models\MainGPN\tbIRFlux;
use HashPN\Models\MainGPN\tbIRMag;
use HashPN\Models\MainGPN\tblogFHalpha;
use HashPN\Models\MainGPN\tblogFOIII;
use HashPN\Models\MainGPN\tbPA;
use HashPN\Models\MainGPN\tbPNMorph;
use HashPN\Models\MainGPN\tbRadioCont;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class FlagMap
 * 
 * @property int $idflagMap
 * @property string $flag
 * @property string $flagExpl
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tb_ang_diams
 * @property \Illuminate\Database\Eloquent\Collection $tbHrvel
 * @property \Illuminate\Database\Eloquent\Collection $tbIRFluxes
 * @property \Illuminate\Database\Eloquent\Collection $tbIRMag
 * @property \Illuminate\Database\Eloquent\Collection $tbPA
 * @property \Illuminate\Database\Eloquent\Collection $tbPNMorph
 * @property \Illuminate\Database\Eloquent\Collection $tbRadioCont
 * @property \Illuminate\Database\Eloquent\Collection $tblogFHalpha
 * @property \Illuminate\Database\Eloquent\Collection $tblogFOIII
 *

 */
class FlagMap extends Eloquent
{
	protected $table = 'flagMap';
	protected $primaryKey = 'idflagMap';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $fillable = [
		'flag',
		'flagExpl'
	];

	public function tbAngDiam()
	{
		return $this->hasMany(tbAngDiam::class, 'flagPAdiam', 'flag');
	}

	public function tbHrvel()
	{
		return $this->hasMany(tbHrvel::class, 'flagH_rad_vel', 'flag');
	}

	public function tbIRFluxes()
	{
		return $this->hasMany(tbIRFlux::class, 'flagFlux', 'flag');
	}

	public function tbIRMag()
	{
		return $this->hasMany(tbIRMag::class, 'flagMag', 'flag');
	}

	public function tbPA()
	{
		return $this->hasMany(tbPA::class, 'flagEPA', 'flag');
	}

	public function tbPNMorph()
	{
		return $this->hasMany(tbPNMorph::class, 'flagMorph', 'flag');
	}

	public function tbRadioCont()
	{
		return $this->hasMany(tbRadioCont::class, 'flagFlux', 'flag');
	}

	public function tblogFHalpha()
	{
		return $this->hasMany(tblogFHalpha::class, 'flaglogFlux', 'flag');
	}

	public function tblogFOIII()
	{
		return $this->hasMany(tblogFOIII::class, 'flaglogFlux', 'flag');
	}
}
