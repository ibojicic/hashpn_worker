<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class NVSS
 * 
 * @property int $idNVSS
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
 * @property string $DATE-MAP
 * @property float $CDELT1
 * @property float $CDELT2
 * @property string $DATE_OBS
 * @property float $DATAMAX
 * @property float $DATAMIN
 *

 */
class NVSS extends Eloquent
{
	protected $table = 'NVSS';
	protected $primaryKey = 'idNVSS';
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
		'DATAMIN' => 'float'
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
		'DATE-MAP',
		'CDELT1',
		'CDELT2',
		'DATE-OBS',
		'DATAMAX',
		'DATAMIN'
	];
}
