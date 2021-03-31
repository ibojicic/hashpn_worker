<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class SDSSFpC
 * 
 * @property int $idSDSS_fpC
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
 * @property int $RUN
 * @property int $FRAME
 * @property string $DATE-OBS
 * @property string $TAIHMS
 * @property int $STRIPE
 * @property int $BADLINES
 * @property string $FILTER
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 *

 */
class SDSSFpC extends Eloquent
{
	protected $table = 'SDSS_fpC';
	protected $primaryKey = 'idSDSS_fpC';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'RUN' => 'int',
		'FRAME' => 'int',
		'STRIPE' => 'int',
		'BADLINES' => 'int',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
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
		'NAXIS1',
		'NAXIS2',
		'BUNIT',
		'OBJECT',
		'RUN',
		'FRAME',
		'DATE-OBS',
		'TAIHMS',
		'STRIPE',
		'BADLINES',
		'FILTER',
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2'
	];
}
