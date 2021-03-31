<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class SPITZERTARGET
 * 
 * @property int $idSPITZER_TARGET
 * @property string $file_name
 * @property string $band
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property string $BUNIT
 * @property float $GAIN
 * @property float $FLUXCONV
 * @property float $PXSCAL1
 * @property float $PXSCAL2
 *

 */
class SPITZER_TARGET extends Eloquent
{
	protected $table = 'SPITZER_TARGET';
	protected $primaryKey = 'idSPITZER_TARGET';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'GAIN' => 'float',
		'FLUXCONV' => 'float',
		'PXSCAL1' => 'float',
		'PXSCAL2' => 'float'

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
		'NAXIS1',
		'NAXIS2',
		'BUNIT',
		'GAIN',
		'FLUXCONV',
		'PXSCAL1',
		'PXSCAL2'
	];
}
