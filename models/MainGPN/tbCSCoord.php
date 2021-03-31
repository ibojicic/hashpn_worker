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
 * Class TbCSCoord
 * 
 * @property int $idtbCSCoords
 * @property string $CS_RAJ2000
 * @property string $CS_DECJ2000
 * @property float $CS_DRAJ2000
 * @property float $CS_DDECJ2000
 * @property float $CS_Glon
 * @property float $CS_Glat
 * @property string $reference
 * @property string $CSstat
 * @property string $refCSstat
 * @property string $refTable
 * @property string $refRecord
 * @property int $InUse
 * @property string $refInUse
 * @property string $userRecord
 * @property int $idPNMain
 * @property string $comments
 *
 * @property ReferenceIDs $ReferenceIDs
 * @property PNMain $PNMain
 * @property userslist $userslist
 * @property DataInfo $DataInfo
 * @property \Illuminate\Database\Eloquent\Collection $mPNMain
 *

 */
class tbCSCoords extends Eloquent
{

    protected $table = 'tbCSCoords';
    protected $primaryKey = 'idtbCSCoords';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'CS_DRAJ2000' => 'float',
		'CS_DDECJ2000' => 'float',
		'CS_Glon' => 'float',
		'CS_Glat' => 'float',
		'InUse' => 'int',
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'CS_RAJ2000',
		'CS_DECJ2000',
		'CS_DRAJ2000',
		'CS_DDECJ2000',
		'CS_Glon',
		'CS_Glat',
		'reference',
		'CSstat',
		'refCSstat',
		'refTable',
		'refRecord',
		'InUse',
		'refInUse',
		'userRecord',
		'idPNMain',
		'comments'
	];

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
		return $this->belongsToMany(PNMain::class, 'PNMain_tbCSCoords', 'idtbCSCoords', 'idPNMain');
	}
}
