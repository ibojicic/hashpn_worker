<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use HashPN\Models\MainPNUsers\userslist;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class TbUsrComm
 * 
 * @property int $idtbUsrComm
 * @property int $idPNMain
 * @property string $user
 * @property string $public
 * @property string $comment
 * @property \Carbon\Carbon $date
 *
 * @property PNMain $PNMain
 * @property userslist $userslist
 *

 */
class tbUsrComm extends Eloquent
{
	protected $table = 'tbUsrComm';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'user',
		'public',
		'comment',
		'date'
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
