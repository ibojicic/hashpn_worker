<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MIPSGAL24
 * 
 * @property int $idMIPSGAL24
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
 * @property int $CHNLNUM
 * @property float $WAVELENG
 * @property int $PROGID
 * @property float $LPLATE
 * @property float $BPLATE
 * @property string $DATE_OBS
 * @property float $CDELT1
 * @property float $CDELT2
 * @property float $CROTA2
 * @property string $BUNIT
 * @property float $DATAMIN
 * @property float $DATAMAX
 * @property float $EXPTIME
 * @property float $MEANEXP
 * @property float $GAIN
 * @property float $FLUXCONV
 *

 */
class MIPSGAL24 extends Eloquent
{
	protected $table = 'MIPSGAL24';
	protected $primaryKey = 'idMIPSGAL24';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'CHNLNUM' => 'int',
		'WAVELENG' => 'float',
		'PROGID' => 'int',
		'LPLATE' => 'float',
		'BPLATE' => 'float',
		'CDELT1' => 'float',
		'CDELT2' => 'float',
		'CROTA2' => 'float',
		'DATAMIN' => 'float',
		'DATAMAX' => 'float',
		'EXPTIME' => 'float',
		'MEANEXP' => 'float',
		'GAIN' => 'float',
		'FLUXCONV' => 'float'
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
		'CHNLNUM',
		'WAVELENG',
		'PROGID',
		'LPLATE',
		'BPLATE',
		'DATE_OBS',
		'CDELT1',
		'CDELT2',
		'CROTA2',
		'BUNIT',
		'DATAMIN',
		'DATAMAX',
		'EXPTIME',
		'MEANEXP',
		'GAIN',
		'FLUXCONV'
	];
}
