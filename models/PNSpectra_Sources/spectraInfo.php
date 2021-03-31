<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:09:22 +0000.
 */

namespace HashPN\Models\PNSpectra_Sources;

use HashPN\Models\MainPNUsers\userslist;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class spectraInfo
 * 
 * @property int $idspectraInfo
 * @property string $name
 * @property string $source
 * @property string $path
 * @property string $url
 * @property string $mapTable
 * @property string $user
 * @property \Carbon\Carbon $dateAdded
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Userslist $userslist
 * @property \Illuminate\Database\Eloquent\Collection $FitsFiles
 *
 
 */
class spectraInfo extends Eloquent
{

    protected $table = 'spectraInfo';
    protected $primaryKey = 'idspectraInfo';
    public $timestamps = true;
    protected $connection = "PNSpectra_Sources";


    protected $dates = [
		'dateAdded'
	];

	protected $fillable = [
		'name',
		'source',
		'path',
		'url',
		'mapTable',
		'user',
		'dateAdded',
		'type',
        'created_at',
        'updated_at'
    ];

	public function userslist()
	{
		return $this->belongsTo(userslist::class, 'user', 'userName');
	}

	public function FitsFiles()
	{
		return $this->hasMany(FitsFiles::class, 'setname', 'name');
	}
}
