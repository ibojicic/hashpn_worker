<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:48:08 +0000.
 */

namespace HashPN\Models\MainPNUsers;

use HashPN\Models\MainGPN\PNMain;
use HashPN\Models\MainGPN\ReferenceIDs;
use HashPN\Models\MainGPN\samplesInfo;
use HashPN\Models\MainGPN\tbAngExt;
use HashPN\Models\MainGPN\tbCName;
use HashPN\Models\MainGPN\tbCSCoord;
use HashPN\Models\MainGPN\tbHrvel;
use HashPN\Models\MainGPN\tbIRFlux;
use HashPN\Models\MainGPN\tbIRMag;
use HashPN\Models\MainGPN\tblogFHalpha;
use HashPN\Models\MainGPN\tblogFOIII;
use HashPN\Models\MainGPN\tbPA;
use HashPN\Models\MainGPN\tbPNMorph;
use HashPN\Models\MainGPN\tbRadioCont;
use HashPN\Models\MainGPN\tbUsrComm;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Userslist
 * 
 * @property int $ID
 * @property string $userName
 * @property string $userPass
 * @property int $isAdmin
 * @property int $userGroup
 * @property string $sessionID
 * @property \Carbon\Carbon $lastLog
 * @property string $userRemark
 * @property string $firstName
 * @property string $lastName
 * @property string $affiliation
 * @property string $email
 * @property string $activationKey
 * @property string $specAccess
 * 
 * @property \Illuminate\Database\Eloquent\Collection $PNMain
 * @property \Illuminate\Database\Eloquent\Collection $ReferenceIDss
 * @property \Illuminate\Database\Eloquent\Collection $samples_infos
 * @property \Illuminate\Database\Eloquent\Collection $tbAngExt
 * @property \Illuminate\Database\Eloquent\Collection $tbCName
 * @property \Illuminate\Database\Eloquent\Collection $tbCSCoord
 * @property \Illuminate\Database\Eloquent\Collection $tbHrvel
 * @property \Illuminate\Database\Eloquent\Collection $tbIRFluxes
 * @property \Illuminate\Database\Eloquent\Collection $tbIRMag
 * @property \Illuminate\Database\Eloquent\Collection $tbPA
 * @property \Illuminate\Database\Eloquent\Collection $tbPNMorph
 * @property \Illuminate\Database\Eloquent\Collection $tbRadioCont
 * @property \Illuminate\Database\Eloquent\Collection $tb_usr_comms
 * @property \Illuminate\Database\Eloquent\Collection $tblogFHalpha
 * @property \Illuminate\Database\Eloquent\Collection $tblogFOIII
 * @property \Illuminate\Database\Eloquent\Collection $accesslogs
 * @property \Illuminate\Database\Eloquent\Collection $userssession_logs
 * @property \Illuminate\Database\Eloquent\Collection $userssession_workings
 *

 */
class userslist extends Eloquent
{
	protected $table = 'userslist';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'isAdmin' => 'int',
		'userGroup' => 'int'
	];

	protected $dates = [
		'lastLog'
	];

	protected $fillable = [
		'userName',
		'userPass',
		'isAdmin',
		'userGroup',
		'sessionID',
		'lastLog',
		'userRemark',
		'firstName',
		'lastName',
		'affiliation',
		'email',
		'activationKey',
		'specAccess'
	];
	public function PNMain()
	{
		return $this->hasMany(PNMain::class, 'userRecord', 'userName');
	}

	public function ReferenceIDs()
	{
		return $this->hasMany(ReferenceIDs::class, 'user', 'userName');
	}

	public function samplesInfo()
	{
		return $this->hasMany(samplesInfo::class, 'User', 'userName');
	}

	public function tbAngExt()
	{
		return $this->hasMany(tbAngExt::class, 'userRecord', 'userName');
	}

	public function tbCName()
	{
		return $this->hasMany(tbCName::class, 'userRecord', 'userName');
	}

	public function tbCSCoord()
	{
		return $this->hasMany(tbCSCoord::class, 'userRecord', 'userName');
	}

	public function tbHrvel()
	{
		return $this->hasMany(tbHrvel::class, 'userRecord', 'userName');
	}

	public function tbIRFluxes()
	{
		return $this->hasMany(tbIRFlux::class, 'userRecord', 'userName');
	}

	public function tbIRMag()
	{
		return $this->hasMany(tbIRMag::class, 'userRecord', 'userName');
	}

	public function tbPA()
	{
		return $this->hasMany(tbPA::class, 'userRecord', 'userName');
	}

	public function tbPNMorph()
	{
		return $this->hasMany(tbPNMorph::class, 'userRecord', 'userName');
	}

	public function tbRadioCont()
	{
		return $this->hasMany(tbRadioCont::class, 'userRecord', 'userName');
	}

	public function tbUsrComm()
	{
		return $this->hasMany(tbUsrComm::class, 'user', 'userName');
	}

	public function tblogFHalpha()
	{
		return $this->hasMany(tblogFHalpha::class, 'userRecord', 'userName');
	}

	public function tblogFOIII()
	{
		return $this->hasMany(tblogFOIII::class, 'userRecord', 'userName');
	}

	public function accesslog()
	{
		return $this->hasMany(accesslog::class, 'user', 'userName');
	}

	public function userssession_log()
	{
		return $this->hasMany(userssession_log::class, 'userName', 'userName');
	}

	public function userssession_working()
	{
		return $this->hasMany(userssession_working::class, 'userName', 'userName');
	}
}
