<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 11:37:59 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Helppage
 * 
 * @property int $idhelppages
 * @property string $topic
 * @property string $title
 * @property string $text
 * @property string $user
 * @property \Carbon\Carbon $date
 * @property int $order
 *

 */
class Helppage extends Eloquent
{
	protected $primaryKey = 'idhelppages';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'order' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'topic',
		'title',
		'text',
		'user',
		'date',
		'order'
	];
}
