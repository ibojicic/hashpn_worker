<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use App\Models\MainPNData\DataInfo;
use HashPN\Models\MainPNUsers\userslist;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class TbIRFlux
 * 
 * @property int $idtbIRFlux
 * @property string $flagFlux
 * @property float $Flux
 * @property float $errFlux
 * @property string $instrument
 * @property string $band
 * @property string $reference
 * @property string $refTable
 * @property int $refRecord
 * @property int $InUse
 * @property string $refInUse
 * @property string $userRecord
 * @property int $idPNMain
 * @property string $comments
 *
 * @property flagMap $flagMap
 * @property ReferenceIDs $ReferenceIDs
 * @property PNMain $PNMain
 * @property DataInfo $DataInfo
 * @property userslist $userslist
 * @property \Illuminate\Database\Eloquent\Collection $mPNMain
 *

 */
class tbIRFlux extends Eloquent
{
	protected $table = 'tbIRFlux';
	protected $primaryKey = 'idtbIRFlux';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'Flux' => 'float',
		'errFlux' => 'float',
		'refRecord' => 'int',
		'InUse' => 'int',
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'flagFlux',
		'Flux',
		'errFlux',
		'instrument',
		'band',
		'reference',
		'refTable',
		'refRecord',
		'InUse',
		'refInUse',
		'userRecord',
		'idPNMain',
		'comments'
	];

	public function flagMap()
	{
		return $this->belongsTo(flagMap::class, 'flagFlux', 'flag');
	}

	public function ReferenceIDs()
	{
		return $this->belongsTo(ReferenceIDs::class, 'reference', 'Identifier');
	}

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function DataInfo()
	{
		return $this->belongsTo(DataInfo::class, 'refTable', 'Name');
	}

	public function userslist()
	{
		return $this->belongsTo(userslist::class, 'userRecord', 'userName');
	}

	public function mPNMain()
	{
		return $this->belongsToMany(PNMain::class, 'PNMain_tbIRFlux', 'idtbIRFlux', 'idPNMain')
					->withPivot('band');
	}
}
