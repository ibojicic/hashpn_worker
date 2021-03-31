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
 * Class TbPA
 * 
 * @property int $idtbPA
 * @property string $flagEPA
 * @property float $EPA
 * @property float $GPA
 * @property float $errPA
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
class tbPA extends Eloquent
{
	protected $table = 'tbPA';
	protected $primaryKey = 'idtbPA';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'EPA' => 'float',
		'GPA' => 'float',
		'errPA' => 'float',
		'refRecord' => 'int',
		'InUse' => 'int',
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'flagEPA',
		'EPA',
		'GPA',
		'errPA',
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
		return $this->belongsTo(flagMap::class, 'flagEPA', 'flag');
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
