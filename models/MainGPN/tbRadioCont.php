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
 * Class TbRadioCont
 * 
 * @property int $idtbRadioCont
 * @property string $flagFlux
 * @property float $Flux
 * @property float $errFlux
 * @property float $freq
 * @property string $band
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
 *

 */
class tbRadioCont extends Eloquent
{
	protected $table = 'tbRadioCont';
	protected $primaryKey = 'idtbRadioCont';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'Flux' => 'float',
		'errFlux' => 'float',
		'freq' => 'float',
		'refRecord' => 'int',
		'InUse' => 'int',
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'flagFlux',
		'Flux',
		'errFlux',
		'freq',
		'band',
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

	public function userslist()
	{
		return $this->belongsTo(userslist::class, 'userRecord', 'userName');
	}

	public function DataInfo()
	{
		return $this->belongsTo(DataInfo::class, 'refTable', 'Name');
	}
}
