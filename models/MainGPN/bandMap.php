<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

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
class bandMap extends Eloquent
{
	protected $table = 'bandMap';
	protected $primaryKey = 'idbandMap';
	public $timestamps = false;
    protected $connection = "MainGPN";


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
