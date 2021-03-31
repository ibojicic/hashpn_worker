<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

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
class flagMap extends Eloquent
{
	protected $table = 'flagMap';
	protected $primaryKey = 'idflagMap';
	public $timestamps = false;
    protected $connection = "MainGPN";


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
