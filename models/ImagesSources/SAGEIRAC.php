<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class SAGEIRAC
 * 
 * @property int $idSAGE_IRAC
 * @property string $file_name
 * @property string $band
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $RA
 * @property float $DEC
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property float $DELTA_X
 * @property float $DELTA_Y
 * @property float $BORDER
 * @property string $BUNIT
 * @property float $GAIN
 * @property float $JY2DN
 * @property float $ETIMEAVE
 * @property float $PA_AVE
 * @property float $ZODY_AVE
 * @property float $FLUXCONV
 * @property float $CD1_1
 * @property float $CD2_2
 *

 */
class SAGE_IRAC extends Eloquent
{
	protected $table = 'SAGE_IRAC';
	protected $primaryKey = 'idSAGE_IRAC';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'RA' => 'float',
		'DEC' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'DELTA-X' => 'float',
		'DELTA-Y' => 'float',
		'BORDER' => 'float',
		'GAIN' => 'float',
		'JY2DN' => 'float',
		'ETIMEAVE' => 'float',
		'PA_AVE' => 'float',
		'ZODY_AVE' => 'float',
		'FLUXCONV' => 'float',
		'CD1_1' => 'float',
		'CD2_2' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'CTYPE1',
		'CTYPE2',
		'CRPIX1',
		'CRPIX2',
		'CRVAL1',
		'CRVAL2',
		'RA',
		'DEC',
		'NAXIS1',
		'NAXIS2',
		'DELTA-X',
		'DELTA-Y',
		'BORDER',
		'BUNIT',
		'GAIN',
		'JY2DN',
		'ETIMEAVE',
		'PA_AVE',
		'ZODY_AVE',
		'FLUXCONV',
		'CD1_1',
		'CD2_2'
	];
}
