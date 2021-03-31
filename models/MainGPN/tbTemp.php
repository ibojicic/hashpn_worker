<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class TbTemp
 * 
 * @property int $idtbTemp
 * @property string $flagData
 * @property float $data
 * @property string $refTable
 * @property int $refRecord
 * @property int $InUse
 * @property string $userRecord
 * @property int $idPNMain
 * @property string $comments
 *

 */
class tbTemp extends Eloquent
{
	protected $table = 'tbTemp';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'data' => 'float',
		'refRecord' => 'int',
		'InUse' => 'int',
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'flagData',
		'data',
		'refTable',
		'refRecord',
		'InUse',
		'userRecord',
		'comments'
	];
}
