<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use HashPN\Models\MainPNUsers\userslist;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class SamplesInfo
 * 
 * @property int $idSamples
 * @property string $Name
 * @property string $User
 * @property string $database
 * @property string $table
 * @property string $column
 * @property string $sampleid
 * @property string $title
 * @property string $class
 * @property string $type
 * @property string $color
 * @property int $default
 * @property string $canAdd
 * 
 * @property userslist $userslist
 *

 */
class samplesInfo extends Eloquent
{
	protected $table = 'samplesInfo';
	protected $primaryKey = 'idSamples';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'default' => 'int'
	];

	protected $fillable = [
		'Name',
		'User',
		'database',
		'table',
		'column',
		'sampleid',
		'title',
		'class',
		'type',
		'color',
		'default',
		'canAdd'
	];

	public function userslist()
	{
		return $this->belongsTo(userslist::class, 'User', 'userName');
	}
}
