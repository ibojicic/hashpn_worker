<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Weidmann2016
 * 
 * @property int $idPOPIPLAN_ESO
 * @property string $file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property string $EXTEND
 * @property string $DATE
 * @property string $IRAF-TLM
 * @property string $OBJECT
 * @property string $CCDSIZE
 * @property string $CCDSUM
 * @property string $GAIN
 * @property string $ADCRATE
 * @property float $CAMTEM
 * @property float $EXPTIME
 * @property string $OBSERVAT
 * @property string $DATE_OBS
 * @property string $TIME_OBS
 * @property string $UT
 * @property string $ST
 * @property string $HA
 * @property string $RA
 * @property string $DEC
 * @property float $EQUINOX
 * @property float $MJD-OBS
 * @property float $ZD
 * @property float $AIRMASS
 * @property string $IMAGETYP
 * @property string $INSTRUME
 * @property string $OBSERVER
 * @property string $FILTER01
 * @property string $FILTER02
 * @property int $WCSDIM
 * @property float $LTM1_1
 * @property float $LTM2_2
 * @property string $WAT0_001
 * @property string $WAT1_001
 * @property string $WAT2_001
 * @property string $CCDSEC
 * @property string $BIASSEC
 * @property float $LTV1
 * @property float $LTV2
 * @property string $CCDPROC
 * @property string $FLATCOR
 * @property string $IMCMB001
 * @property string $IMCMB002
 * @property string $IMCMB003
 * @property int $NCOMBINE
 * @property float $LTM2_1
 * @property float $LTM1_2
 *

 */
class Weidmann2016 extends Eloquent
{
	protected $table = 'Weidmann_2016';
	protected $primaryKey = 'idPOPIPLAN_ESO';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'CAMTEM' => 'float',
		'EXPTIME' => 'float',
		'EQUINOX' => 'float',
		'MJD-OBS' => 'float',
		'ZD' => 'float',
		'AIRMASS' => 'float',
		'WCSDIM' => 'int',
		'LTM1_1' => 'float',
		'LTM2_2' => 'float',
		'LTV1' => 'float',
		'LTV2' => 'float',
		'NCOMBINE' => 'int',
		'LTM2_1' => 'float',
		'LTM1_2' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'NAXIS1',
		'NAXIS2',
		'EXTEND',
		'DATE',
		'IRAF-TLM',
		'OBJECT',
		'CCDSIZE',
		'CCDSUM',
		'GAIN',
		'ADCRATE',
		'CAMTEM',
		'EXPTIME',
		'OBSERVAT',
		'DATE-OBS',
		'TIME-OBS',
		'UT',
		'ST',
		'HA',
		'RA',
		'DEC',
		'EQUINOX',
		'MJD-OBS',
		'ZD',
		'AIRMASS',
		'IMAGETYP',
		'INSTRUME',
		'OBSERVER',
		'FILTER01',
		'FILTER02',
		'WCSDIM',
		'LTM1_1',
		'LTM2_2',
		'WAT0_001',
		'WAT1_001',
		'WAT2_001',
		'CCDSEC',
		'BIASSEC',
		'LTV1',
		'LTV2',
		'CCDPROC',
		'FLATCOR',
		'IMCMB001',
		'IMCMB002',
		'IMCMB003',
		'NCOMBINE',
		'LTM2_1',
		'LTM1_2'
	];
}
