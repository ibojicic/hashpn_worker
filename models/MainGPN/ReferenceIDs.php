<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use App\Models\MainPNData\DataInfo;
use HashPN\Models\MainPNUsers\userslist;
use HashPN\Models\PNSpectra_Sources\spectraLinks;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class ReferenceID
 * 
 * @property int $idReferenceIDs
 * @property string $Identifier
 * @property float $Score
 * @property string $Author
 * @property string $Title
 * @property string $Journal
 * @property string $Year
 * @property string $URL
 * @property string $Keywords
 * @property string $Origin
 * @property string $Abstract
 * @property string $Items
 * @property string $elcatCode
 * @property string $parsedIn
 * @property string $user
 * @property string $comments
 * 
 * @property userslist $userslist
 * @property \Illuminate\Database\Eloquent\Collection $PNMain
 * @property \Illuminate\Database\Eloquent\Collection $tb_ang_diams
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
 * @property \Illuminate\Database\Eloquent\Collection $DataInfo
 * @property \Illuminate\Database\Eloquent\Collection $spectraLinks
 *

 */
class ReferenceIDs extends Eloquent
{
	public $timestamps = false;
    protected $connection = "MainGPN";
    protected $table = 'ReferenceIDs';
    protected $primaryKey = 'idReferenceIDs';

    protected $casts = [
		'Score' => 'float'
	];

	protected $fillable = [
		'Score',
		'Author',
		'Title',
		'Journal',
		'Year',
		'URL',
		'Keywords',
		'Origin',
		'Abstract',
		'Items',
		'elcatCode',
		'parsedIn',
		'user',
		'comments'
	];

	public function userslist()
	{
		return $this->belongsTo(userslist::class, 'user', 'userName');
	}

	public function PNMain()
	{
		return $this->hasMany(PNMain::class, 'refCoord', 'Identifier');
	}

	public function tbAngDiam()
	{
		return $this->hasMany(tbAngDiam::class, 'reference', 'Identifier');
	}

	public function tbAngExt()
	{
		return $this->hasMany(tbAngExt::class, 'reference', 'Identifier');
	}

	public function tbCName()
	{
		return $this->hasMany(tbCName::class, 'reference', 'Identifier');
	}

	public function tbCSCoord()
	{
		return $this->hasMany(tbCSCoord::class, 'reference', 'Identifier');
	}

	public function tbHrvel()
	{
		return $this->hasMany(tbHrvel::class, 'reference', 'Identifier');
	}

	public function tbIRFluxes()
	{
		return $this->hasMany(tbIRFlux::class, 'reference', 'Identifier');
	}

	public function tbIRMag()
	{
		return $this->hasMany(tbIRMag::class, 'reference', 'Identifier');
	}

	public function tbPA()
	{
		return $this->hasMany(tbPA::class, 'reference', 'Identifier');
	}

	public function tbPNMorph()
	{
		return $this->hasMany(tbPNMorph::class, 'reference', 'Identifier');
	}

	public function tbRadioCont()
	{
		return $this->hasMany(tbRadioCont::class, 'reference', 'Identifier');
	}

	public function tblogFHalpha()
	{
		return $this->hasMany(tblogFHalpha::class, 'reference', 'Identifier');
	}

	public function tblogFOIII()
	{
		return $this->hasMany(tblogFOIII::class, 'reference', 'Identifier');
	}

	public function DataInfo()
	{
		return $this->hasMany(DataInfo::class, 'sourcePaper', 'Identifier');
	}

	public function spectraLinks()
	{
		return $this->hasMany(spectraLinks::class, 'reference', 'Identifier');
	}
}
