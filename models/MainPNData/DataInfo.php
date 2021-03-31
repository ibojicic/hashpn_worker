<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:47:39 +0000.
 */

namespace HashPN\Models\MainPNData;

use HashPN\Models\MainGPN\ReferenceIDs;
use HashPN\Models\MainGPN\tbAngDiam;
use HashPN\Models\MainGPN\tbCName;
use HashPN\Models\MainGPN\tbCSCoord;
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
 * Class DataInfo
 * 
 * @property int $idDataInfo
 * @property string $Name
 * @property string $CatName
 * @property string $CatTitle
 * @property string $TabName
 * @property string $TabTitle
 * @property string $sourcePaper
 * @property string $Mapped
 * @property string $MappedTo
 * @property string $MapKey
 * @property \Carbon\Carbon $Date
 * @property string $Link
 * @property string $Comments
 * @property string $checked
 * @property string $Catalogue
 * @property int $lastidPNMain
 * @property string $checkNew
 * @property string $full
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property ReferenceIDs $ReferenceIDs
 * @property \Illuminate\Database\Eloquent\Collection $tbAngExt
 * @property \Illuminate\Database\Eloquent\Collection $tbCName
 * @property \Illuminate\Database\Eloquent\Collection $tbCSCoord
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
class DataInfo extends Eloquent
{
	protected $table = 'DataInfo';
	protected $primaryKey = 'idDataInfo';
    public $timestamps = true;
    protected $connection = "MainPNData";


    protected $casts = [
		'lastidPNMain' => 'int'
	];

	protected $dates = [
		'Date'
	];

	protected $fillable = [
		'Name',
		'CatName',
		'CatTitle',
		'TabName',
		'TabTitle',
		'sourcePaper',
		'Mapped',
		'MappedTo',
		'MapKey',
		'Date',
		'Link',
		'Comments',
		'checked',
		'Catalogue',
		'lastidPNMain',
		'checkNew',
		'full',
        'created_at',
        'updated_at'
    ];

	public function ReferenceIDs()
	{
		return $this->belongsTo(ReferenceIDs::class, 'sourcePaper', 'Identifier');
	}

	public function tbAngExt()
	{
		return $this->hasMany(tbAngDiam::class, 'refTable', 'Name');
	}

	public function tbCName()
	{
		return $this->hasMany(tbCName::class, 'refTable', 'Name');
	}

	public function tbCSCoord()
	{
		return $this->hasMany(tbCSCoord::class, 'refTable', 'Name');
	}

	public function tbHrvel()
	{
		return $this->hasMany(tbHrvel::class, 'refTable', 'Name');
	}

	public function tbIRFluxes()
	{
		return $this->hasMany(tbIRFlux::class, 'refTable', 'Name');
	}

	public function tbIRMag()
	{
		return $this->hasMany(tbIRMag::class, 'refTable', 'Name');
	}

	public function tbPA()
	{
		return $this->hasMany(tbPA::class, 'refTable', 'Name');
	}

	public function tbPNMorph()
	{
		return $this->hasMany(tbPNMorph::class, 'refTable', 'Name');
	}

	public function tbRadioCont()
	{
		return $this->hasMany(tbRadioCont::class, 'refTable', 'Name');
	}

	public function tblogFHalpha()
	{
		return $this->hasMany(tblogFHalpha::class, 'refTable', 'Name');
	}

	public function tblogFOIII()
	{
		return $this->hasMany(tblogFOIII::class, 'refTable', 'Name');
	}
}
