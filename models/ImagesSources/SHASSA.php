<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class SHASSA
 * 
 * @property int $idSHASSA
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
 * @property int $XMIN
 * @property int $XMAX
 * @property int $YMIN
 * @property int $YMAX
 * @property string $DATE-OBS
 * @property string $TIME-OBS
 * @property float $PIX_SIZE
 *

 */
class SHASSA extends Eloquent
{
	protected $table = 'SHASSA';
	protected $primaryKey = 'idSHASSA';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'XMIN' => 'int',
		'XMAX' => 'int',
		'YMIN' => 'int',
		'YMAX' => 'int',
		'PIX_SIZE' => 'float'
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
		'XMIN',
		'XMAX',
		'YMIN',
		'YMAX',
		'DATE-OBS',
		'TIME-OBS',
		'PIX_SIZE'
	];
}
