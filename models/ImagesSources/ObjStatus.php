<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 11:37:59 +0000.
 */

namespace HashPN\Models\ImagesSources;

use HashPN\Models\MainGPN\PNMain;
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
class ObjStatus extends Eloquent
{
	protected $table = 'objStatus';
	protected $primaryKey = 'idobjStatus';
	public $timestamps = false;
    protected $connection = "ImagesSources";


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
