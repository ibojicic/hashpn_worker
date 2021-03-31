<?php

/**
 * Created by Ivan.
 * Date: Thu, 6 March 2019 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Kris_VLT
 * 
 * @property int $idKris_VLT
 * @property string $file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property string $OBJECT
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property float $RA
 * @property float $DEC
 */
class Kris_VLT extends Eloquent
{
	protected $table = 'Kris_VLT';
	protected $primaryKey = 'idKris_VLT';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
        'CRVAL1' => 'float',
        'CRVAL2' => 'float',
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
        'CTYPE1' => 'string',
        'CTYPE2' => 'string',
        'OBJECT' => 'string',
        'CD1_1' => 'float',
        'CD1_2' => 'float',
        'CD2_1' => 'float',
        'CD2_2' => 'float',
        'RA' => 'float',
        'DEC' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
        'NAXIS1',
        'NAXIS2',
        'CRVAL1',
        'CRVAL2',
        'CRPIX1',
        'CRPIX2',
        'CTYPE1',
        'CTYPE2',
        'OBJECT',
        'CD1_1',
        'CD1_2',
        'CD2_1',
        'CD2_2',
        'RA',
        'DEC'
	];
}
