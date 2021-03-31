<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:48:08 +0000.
 */

namespace HashPN\Models\MainPNUsers;

use HashPN\Models\MainGPN\PNMain;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Accesslog
 * 
 * @property int $idaccesslog
 * @property string $user
 * @property string $page
 * @property int $idPNMain
 * @property \Carbon\Carbon $date
 * @property int $dateunix
 * @property string $flag
 * 
 * @property PNMain $PNMain
 * @property userslist $userslist
 *

 */
class accesslog extends Eloquent
{
	protected $table = 'accesslog';
	protected $primaryKey = 'idaccesslog';
	public $timestamps = false;

	protected $casts = [
		'idPNMain' => 'int',
		'dateunix' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'user',
		'page',
		'idPNMain',
		'date',
		'dateunix',
		'flag'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function userslist()
	{
		return $this->belongsTo(userslist::class, 'user', 'userName');
	}
}
