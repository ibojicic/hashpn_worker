<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 11:37:59 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class BandMap
 * 
 * @property int $idbandMap
 * @property string $name
 * @property string $type
 * @property float $freq
 * @property float $wavelength
 * @property string $instr
 * @property string $comments
 *

 */
class BandMap extends Eloquent
{
	protected $table = 'bandMap';
	protected $primaryKey = 'idbandMap';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'freq' => 'float',
		'wavelength' => 'float'
	];

	protected $fillable = [
		'name',
		'type',
		'freq',
		'wavelength',
		'instr',
		'comments'
	];
}
