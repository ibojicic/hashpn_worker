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
 * Class TbAngDiam
 * 
 * @property int $idtbAngDiam
 * @property string $flagMajDiam
 * @property float $MajDiam
 * @property float $errMajDiam
 * @property string $flagMinDiam
 * @property float $MinDiam
 * @property float $errMinDiam
 * @property string $flagPAdiam
 * @property float $PAdiam
 * @property float $errPAdiam
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
 * @property PNMain $PNMain
 * @property userslist $userslist
 * @property DataInfo $DataInfo
 * @property ReferenceIDs $ReferenceIDs
 * @property \Illuminate\Database\Eloquent\Collection $mPNMain
 *

 */
class tbAngDiam extends Eloquent
{
    protected $primaryKey = 'idtbAngDiam';
    protected $table = 'tbAngDiam';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'MajDiam' => 'float',
		'errMajDiam' => 'float',
		'MinDiam' => 'float',
		'errMinDiam' => 'float',
		'PAdiam' => 'float',
		'errPAdiam' => 'float',
		'refRecord' => 'int',
		'InUse' => 'int',
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'flagMajDiam',
		'MajDiam',
		'errMajDiam',
		'flagMinDiam',
		'MinDiam',
		'errMinDiam',
		'flagPAdiam',
		'PAdiam',
		'errPAdiam',
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
		return $this->belongsTo(flagMap::class, 'flagPAdiam', 'flag');
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

	public function ReferenceIDs()
	{
		return $this->belongsTo(ReferenceIDs::class, 'reference', 'Identifier');
	}

	public function mPNMain()
	{
		return $this->belongsToMany(PNMain::class, 'PNMain_tbAngDiam', 'idtbAngDiam', 'idPNMain');
	}
}
