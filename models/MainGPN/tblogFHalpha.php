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
 * Class TblogFHalpha
 * 
 * @property int $idtblogFHalpha
 * @property string $flaglogFlux
 * @property float $logFlux
 * @property float $errlogFlux
 * @property string $instrument
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
 * @property userslist $userslist
 * @property DataInfo $DataInfo
 * @property \Illuminate\Database\Eloquent\Collection $mPNMain
 *

 */
class tblogFHalpha extends Eloquent
{
	protected $table = 'tblogFHalpha';
	protected $primaryKey = 'idtblogFHalpha';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'logFlux' => 'float',
		'errlogFlux' => 'float',
		'refRecord' => 'int',
		'InUse' => 'int',
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'flaglogFlux',
		'logFlux',
		'errlogFlux',
		'instrument',
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
		return $this->belongsTo(flagMap::class, 'flaglogFlux', 'flag');
	}

	public function ReferenceIDs()
	{
		return $this->belongsTo(ReferenceIDs::class, 'reference', 'Identifier');
	}

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function userslist()
	{
		return $this->belongsTo(userslist::class, 'userRecord', 'userName');
	}

	public function DataInfo()
	{
		return $this->belongsTo(DataInfo::class, 'refTable', 'Name');
	}

	public function mPNMain()
	{
		return $this->belongsToMany(PNMain::class, 'PNMain_tblogFHalpha', 'idtblogFHalpha', 'idPNMain');
	}
}
