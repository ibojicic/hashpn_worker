<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:48:08 +0000.
 */

namespace HashPN\Models\MainPNUsers;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class UserssessionLog
 * 
 * @property int $id
 * @property string $userName
 * @property string $sselect
 * @property string $uselect
 * @property string $fselect
 * @property string $imselect
 * @property string $grimselect
 * @property string $wallselect
 * @property string $view
 * @property string $what
 * @property string $orderby
 * @property int $ipp
 * @property string $testcolumn
 * @property int $viewfirst
 * @property string $orderdir
 * @property \Carbon\Carbon $time
 * @property string $clmnssearch
 * @property string $currentRule
 * @property string $displayRule
 * @property string $currentText
 * @property string $displayText
 * @property string $currentPosition
 * @property string $displayPosition
 * @property string $eselect
 * @property string $distinctList
 * @property string $foundInList
 * @property string $fullWhere
 * @property string $whereMD5
 * @property string $currentIDs
 * 
 * @property userslist $userslist
 *

 */
class userssession_log extends Eloquent
{
	protected $table = 'userssession_log';
	public $timestamps = false;

	protected $casts = [
		'ipp' => 'int',
		'viewfirst' => 'int'
	];

	protected $dates = [
		'time'
	];

	protected $fillable = [
		'userName',
		'sselect',
		'uselect',
		'fselect',
		'imselect',
		'grimselect',
		'wallselect',
		'view',
		'what',
		'orderby',
		'ipp',
		'testcolumn',
		'viewfirst',
		'orderdir',
		'time',
		'clmnssearch',
		'currentRule',
		'displayRule',
		'currentText',
		'displayText',
		'currentPosition',
		'displayPosition',
		'eselect',
		'distinctList',
		'foundInList',
		'fullWhere',
		'whereMD5',
		'currentIDs'
	];

	public function userslist()
	{
		return $this->belongsTo(userslist::class, 'userName', 'userName');
	}
}
