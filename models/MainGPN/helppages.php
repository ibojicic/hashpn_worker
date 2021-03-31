<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

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
class helppages extends Eloquent
{
	protected $primaryKey = 'idhelppages';
	public $timestamps = false;
    protected $connection = "MainGPN";


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
