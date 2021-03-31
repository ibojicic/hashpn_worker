<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class RadioMASH
 * 
 * @property int $idRadioMASH
 * @property string $file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property int $NAXIS3
 * @property int $NAXIS4
 * @property string $EXTEND
 * @property float $BSCALE
 * @property float $BZERO
 * @property string $BUNIT
 * @property string $DATE-OBS
 * @property string $TELESCOP
 * @property float $CRPIX1
 * @property float $CDELT1
 * @property float $CRVAL1
 * @property string $CTYPE1
 * @property float $CRPIX2
 * @property float $CDELT2
 * @property float $CRVAL2
 * @property string $CTYPE2
 * @property float $CRPIX3
 * @property float $CDELT3
 * @property float $CRVAL3
 * @property string $CTYPE3
 * @property float $CRPIX4
 * @property float $CDELT4
 * @property float $CRVAL4
 * @property string $CTYPE4
 * @property string $CELLSCAL
 * @property float $VOBS
 * @property float $BMAJ
 * @property float $BMIN
 * @property float $BPA
 * @property float $EPOCH
 * @property int $NITERS
 * @property string $OBJECT
 * @property float $LSTART
 * @property float $LSTEP
 * @property string $LTYPE
 * @property float $LWIDTH
 * @property string $BTYPE
 *

 */
class RadioMASH extends Eloquent
{
	protected $table = 'RadioMASH';
	protected $primaryKey = 'idRadioMASH';
	public $timestamps = false;
    protected $connection = "ImagesSources";

	protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'NAXIS3' => 'int',
		'NAXIS4' => 'int',
		'BSCALE' => 'float',
		'BZERO' => 'float',
		'CRPIX1' => 'float',
		'CDELT1' => 'float',
		'CRVAL1' => 'float',
		'CRPIX2' => 'float',
		'CDELT2' => 'float',
		'CRVAL2' => 'float',
		'CRPIX3' => 'float',
		'CDELT3' => 'float',
		'CRVAL3' => 'float',
		'CRPIX4' => 'float',
		'CDELT4' => 'float',
		'CRVAL4' => 'float',
		'VOBS' => 'float',
		'BMAJ' => 'float',
		'BMIN' => 'float',
		'BPA' => 'float',
		'EPOCH' => 'float',
		'NITERS' => 'int',
		'LSTART' => 'float',
		'LSTEP' => 'float',
		'LWIDTH' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'NAXIS1',
		'NAXIS2',
		'NAXIS3',
		'NAXIS4',
		'EXTEND',
		'BSCALE',
		'BZERO',
		'BUNIT',
		'DATE-OBS',
		'TELESCOP',
		'CRPIX1',
		'CDELT1',
		'CRVAL1',
		'CTYPE1',
		'CRPIX2',
		'CDELT2',
		'CRVAL2',
		'CTYPE2',
		'CRPIX3',
		'CDELT3',
		'CRVAL3',
		'CTYPE3',
		'CRPIX4',
		'CDELT4',
		'CRVAL4',
		'CTYPE4',
		'CELLSCAL',
		'VOBS',
		'BMAJ',
		'BMIN',
		'BPA',
		'EPOCH',
		'NITERS',
		'OBJECT',
		'LSTART',
		'LSTEP',
		'LTYPE',
		'LWIDTH',
		'BTYPE'
	];
}
