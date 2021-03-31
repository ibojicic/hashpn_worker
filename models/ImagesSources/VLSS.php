<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class VLSS
 * 
 * @property int $idVLSS
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
 * @property string $OBJECT
 * @property float $CDELT1
 * @property float $CDELT2
 * @property string $DATE-OBS
 * @property float $DATAMAX
 * @property float $DATAMIN
 * @property float $CLEANBMJ
 * @property float $CLEANBMN
 * @property int $CLEANNIT
 * @property float $QUANT
 * @property float $BLANK
 * @property float $BSCALE
 * @property float $BZERO
 *

 */
class VLSS extends Eloquent
{
	protected $table = 'VLSS';
	protected $primaryKey = 'idVLSS';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'CDELT1' => 'float',
		'CDELT2' => 'float',
		'DATAMAX' => 'float',
		'DATAMIN' => 'float',
		'CLEANBMJ' => 'float',
		'CLEANBMN' => 'float',
		'CLEANNIT' => 'int',
		'QUANT' => 'float',
		'BLANK' => 'float',
		'BSCALE' => 'float',
		'BZERO' => 'float'
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
		'OBJECT',
		'CDELT1',
		'CDELT2',
		'DATE-OBS',
		'DATAMAX',
		'DATAMIN',
		'CLEANBMJ',
		'CLEANBMN',
		'CLEANNIT',
		'QUANT',
		'BLANK',
		'BSCALE',
		'BZERO'
	];
}
