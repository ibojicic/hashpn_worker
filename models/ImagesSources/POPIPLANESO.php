<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class POPIPLANESO
 * 
 * @property int $idPOPIPLAN_ESO
 * @property string $file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $RA
 * @property float $DEC
 * @property string $MJD-OBS
 * @property string $DATE-OBS
 * @property float $EXPTIME
 * @property float $BSCALE
 * @property float $BZERO
 * @property string $OBJECT
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property string $HIERARCH ESO OBS NAME
 * @property float $HIERARCH_ESO_TEL_AIRM_START
 * @property float $HIERARCH_ESO_TEL_AMBI_FWHM_START
 * @property float $HIERARCH_ESO_TEL_AMBI_RHUM
 * @property float $HIERARCH_ESO_TEL_AIRM_END
 * @property float $HIERARCH_ESO_TEL_AMBI_FWHM_END
 * @property float $HIERARCH_ESO_INS_PIXSCALE
 * @property string $HIERARCH_ESO_INS_FILT1_NAME
 * @property string $ARCFILE
 *

 */
class POPIPLAN_ESO extends Eloquent
{
	protected $table = 'POPIPLAN_ESO';
	protected $primaryKey = 'idPOPIPLAN_ESO';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'RA' => 'float',
		'DEC' => 'float',
		'EXPTIME' => 'float',
		'BSCALE' => 'float',
		'BZERO' => 'float',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
		'CD2_2' => 'float',
		'HIERARCH ESO TEL AIRM START' => 'float',
		'HIERARCH ESO TEL AMBI FWHM START' => 'float',
		'HIERARCH ESO TEL AMBI RHUM' => 'float',
		'HIERARCH ESO TEL AIRM END' => 'float',
		'HIERARCH ESO TEL AMBI FWHM END' => 'float',
		'HIERARCH ESO INS PIXSCALE' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'NAXIS1',
		'NAXIS2',
		'CTYPE1',
		'CTYPE2',
		'CRPIX1',
		'CRPIX2',
		'CRVAL1',
		'CRVAL2',
		'RA',
		'DEC',
		'MJD-OBS',
		'DATE-OBS',
		'EXPTIME',
		'BSCALE',
		'BZERO',
		'OBJECT',
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2',
		'HIERARCH ESO OBS NAME',
		'HIERARCH ESO TEL AIRM START',
		'HIERARCH ESO TEL AMBI FWHM START',
		'HIERARCH ESO TEL AMBI RHUM',
		'HIERARCH ESO TEL AIRM END',
		'HIERARCH ESO TEL AMBI FWHM END',
		'HIERARCH ESO INS PIXSCALE',
		'HIERARCH ESO INS FILT1 NAME',
		'ARCFILE'
	];
}
