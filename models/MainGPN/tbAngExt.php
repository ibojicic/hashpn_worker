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
 * Class TbAngExt
 * 
 * @property int $idtbAngExt
 * @property float $MajExt
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
 * @property PNMain $PNMain
 * @property userslist $userslist
 * @property DataInfo $DataInfo
 * @property ReferenceIDs $ReferenceIDs
 * @property \Illuminate\Database\Eloquent\Collection $mPNMain
 *

 */
class tbAngExt extends Eloquent
{
	protected $table = 'tbAngExt';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'MajExt' => 'float',
		'refRecord' => 'int',
		'InUse' => 'int',
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'MajExt',
		'band',
		'reference',
		'refTable',
		'refRecord',
		'InUse',
		'refInUse',
		'userRecord',
		'comments'
	];

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

	public function ReferenceIDs()
	{
		return $this->belongsTo(ReferenceIDs::class, 'reference', 'Identifier');
	}

	public function mPNMain()
	{
		return $this->belongsToMany(PNMain::class, 'PNMain_tbAngExt', 'idtbAngExt', 'idPNMain');
	}
}
