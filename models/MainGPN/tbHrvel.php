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
 * Class TbHrvel
 * 
 * @property int $idtbHrvel
 * @property string $flagH_rad_vel
 * @property float $H_rad_vel
 * @property float $vel_err
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
class tbHrvel extends Eloquent
{
	protected $table = 'tbHrvel';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'H_rad_vel' => 'float',
		'vel_err' => 'float',
		'refRecord' => 'int',
		'InUse' => 'int',
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'flagH_rad_vel',
		'H_rad_vel',
		'vel_err',
		'reference',
		'refTable',
		'refRecord',
		'InUse',
		'refInUse',
		'userRecord',
		'comments'
	];

	public function flagMap()
	{
		return $this->belongsTo(flagMap::class, 'flagH_rad_vel', 'flag');
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
		return $this->belongsToMany(PNMain::class, 'PNMain_tbHrvel', 'idtbHrvel', 'idPNMain');
	}
}
