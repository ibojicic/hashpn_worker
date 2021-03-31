<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class ObjStatus
 * 
 * @property int $idobjStatus
 * @property string $statusId
 * @property string $statusName
 * @property string $statusTitle
 * @property string $statusDef
 * @property int $order
 * 
 * @property \Illuminate\Database\Eloquent\Collection $PNMain
 *

 */
class objStatus extends Eloquent
{
	protected $table = 'objStatus';
	protected $primaryKey = 'idobjStatus';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'order' => 'int'
	];

	protected $fillable = [
		'statusId',
		'statusName',
		'statusTitle',
		'statusDef',
		'order'
	];

	public function PNMain()
	{
		return $this->hasMany(PNMain::class, 'PNstat', 'statusId');
	}
}
