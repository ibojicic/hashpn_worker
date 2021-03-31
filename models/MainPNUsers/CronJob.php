<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:48:08 +0000.
 */

namespace HashPN\Models\MainPNUsers;

use HashPN\Models\MainGPN\PNMain;use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class cronJobs
 * 
 * @property int $idcronJobs
 * @property string $user
 * @property int $idPNMain
 * @property string $cronScript
 * @property string $parameters
 * @property \Carbon\Carbon $date_subm
 * @property \Carbon\Carbon $date_start
 * @property \Carbon\Carbon $date_exec
 * @property int $priority
 * @property string $zombie
 * @property int $processID
 * @property PNMain $PNMain
 *

 */
class cronJobs extends Eloquent
{
    protected $table = 'cronJobs';
    protected $primaryKey = 'idcronJobs';
	public $timestamps = false;
    protected $connection = "MainPNUsers";


    protected $casts = [
		'idPNMain' => 'int',
		'priority' => 'int'
	];

	protected $dates = [
		'date_subm',
		'date_start',
		'date_exec'
	];

	protected $fillable = [
		'user',
		'idPNMain',
		'cronScript',
		'parameters',
		'date_subm',
		'date_start',
		'date_exec',
		'priority',
        'processID',
        'zombie'
    ];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}
}
