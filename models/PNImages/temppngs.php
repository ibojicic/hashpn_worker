<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:21:10 +0000.
 */

namespace HashPN\Models\PNImages;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Temppng
 * 
 * @property int $idtemppngs
 * @property string $folder
 * @property string $file
 * @property int $idPNMain
 * @property string $del
 *
 
 */
class temppngs  extends Eloquent
{
	protected $primaryKey = 'idtemppngs';
	public $timestamps = false;
    protected $connection = "PNImages";


    protected $casts = [
		'idPNMain' => 'int'
	];

	protected $fillable = [
		'folder',
		'file',
		'idPNMain',
		'del'
	];
}
