<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 11:37:59 +0000.
 */

namespace HashPN\Models\ImagesSources;

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
 * @property \App\Models\Userslist $userslist
 *
 * @package App\RAWMODELS
 */
class SamplesInfo extends Eloquent
{
	protected $table = 'samplesInfo';
	protected $primaryKey = 'idSamples';
	public $timestamps = false;
    protected $connection = "ImagesSources";


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
		return $this->belongsTo(\App\Models\Userslist::class, 'User', 'userName');
	}
}
