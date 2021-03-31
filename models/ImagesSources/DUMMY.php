<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */
namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class DUMMY
 * 
 * @property int $id
 * @property string $file_name
 * @property string $band

 */
class DUMMY extends Eloquent
{
    protected $table = 'DUMMY';
    protected $primaryKey = 'id';
	public $timestamps = false;
    protected $connection = "ImagesSources";


	protected $fillable = [
		'file_name',
		'band',

	];
}
