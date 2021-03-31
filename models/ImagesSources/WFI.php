<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class WFI
 * 
 * @property int $idWFI
 * @property string $file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property float $AIRMEND
 * @property float $AIRMSTRT
 * @property string $DATE
 * @property float $EXPTIME
 * @property string $OBJECT
 * @property string $INSTRUME
 * @property string $TELESCOP
 * @property float $TEL_LAT
 * @property float $TEL_LONG
 * @property float $TEL_ELEV
 * @property float $TEL_ZONE
 * @property string $CHIP_ID
 * @property string $FILT_ID
 * @property string $CTYPE1
 * @property float $CRVAL1
 * @property float $CRPIX1
 * @property string $CTYPE2
 * @property float $CRVAL2
 * @property float $CRPIX2
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property float $STATMIN
 * @property float $STATMAX
 * @property float $STATMEAN
 * @property float $STATDEV
 * @property float $STATMED
 * @property string $OBS_DATE
 * @property string $OBS_NAME
 * @property string $OBS_TYPE
 * @property int $OBS_ID
 * @property string $OBS_PID
 *

 */
class WFI extends Eloquent
{
	protected $table = 'WFI';
	protected $primaryKey = 'idWFI';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'AIRMEND' => 'float',
		'AIRMSTRT' => 'float',
		'EXPTIME' => 'float',
		'TEL_LAT' => 'float',
		'TEL_LONG' => 'float',
		'TEL_ELEV' => 'float',
		'TEL_ZONE' => 'float',
		'CRVAL1' => 'float',
		'CRPIX1' => 'float',
		'CRVAL2' => 'float',
		'CRPIX2' => 'float',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
		'CD2_2' => 'float',
		'STATMIN' => 'float',
		'STATMAX' => 'float',
		'STATMEAN' => 'float',
		'STATDEV' => 'float',
		'STATMED' => 'float',
		'OBS_ID' => 'int'
	];

	protected $fillable = [
		'file_name',
		'band',
		'NAXIS1',
		'NAXIS2',
		'AIRMEND',
		'AIRMSTRT',
		'DATE',
		'EXPTIME',
		'OBJECT',
		'INSTRUME',
		'TELESCOP',
		'TEL_LAT',
		'TEL_LONG',
		'TEL_ELEV',
		'TEL_ZONE',
		'CHIP_ID',
		'FILT_ID',
		'CTYPE1',
		'CRVAL1',
		'CRPIX1',
		'CTYPE2',
		'CRVAL2',
		'CRPIX2',
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2',
		'STATMIN',
		'STATMAX',
		'STATMEAN',
		'STATDEV',
		'STATMED',
		'OBS_DATE',
		'OBS_NAME',
		'OBS_TYPE',
		'OBS_ID',
		'OBS_PID'
	];
}
