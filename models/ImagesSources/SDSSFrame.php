<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class SDSSFrame
 * 
 * @property int $idSDSS_frame
 * @property string $file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property string $EXTEND
 * @property float $BZERO
 * @property float $BSCALE
 * @property float $TAI
 * @property float $RA
 * @property float $DEC
 * @property float $SPA
 * @property float $IPA
 * @property float $IPARATE
 * @property float $AZ
 * @property float $ALT
 * @property float $FOCUS
 * @property \Carbon\Carbon $DATE-OBS
 * @property \Carbon\Carbon $TAIHMS
 * @property string $ORIGIN
 * @property string $TELESCOP
 * @property string $TIMESYS
 * @property int $RUN
 * @property int $FRAME
 * @property int $CCDLOC
 * @property int $STRIPE
 * @property string $STRIP
 * @property string $FLAVOR
 * @property string $OBSERVER
 * @property string $SYS_SCN
 * @property float $EQNX_SCN
 * @property float $NODE
 * @property float $INCL
 * @property float $XBORE
 * @property float $YBORE
 * @property string $OBJECT
 * @property string $EXPTIME
 * @property string $SYSTEM
 * @property string $CCDMODE
 * @property int $C_OBS
 * @property int $COLBIN
 * @property int $ROWBIN
 * @property string $DAVERS
 * @property string $SCDMETHD
 * @property int $SCDWIDTH
 * @property int $SCDDECMF
 * @property int $SCDOFSET
 * @property int $SCDDYNTH
 * @property int $SCDSTTHL
 * @property int $SCDSTTHR
 * @property int $SCDREDSZ
 * @property int $SCDSKYL
 * @property int $SCDSKYR
 * @property int $CAMROW
 * @property int $BADLINES
 * @property int $EQUINOX
 * @property int $SOFTBIAS
 * @property string $BUNIT
 * @property string $FILTER
 * @property int $CAMCOL
 * @property string $VERSION
 * @property string $DERV_VER
 * @property string $ASTR_VER
 * @property string $ASTRO_ID
 * @property string $BIAS_ID
 * @property string $FRAME_ID
 * @property string $KO_VER
 * @property string $PS_ID
 * @property string $ATVSN
 * @property string $RADECSYS
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property string $CUNIT1
 * @property string $CUNIT2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property float $NMGY
 * @property float $NMGYIVAR
 * @property string $VERSIDL
 * @property string $VERSUTIL
 * @property string $VERSPOP
 * @property string $RERUN
 *

 */
class SDSSFrame extends Eloquent
{
	protected $table = 'SDSS_frame';
	protected $primaryKey = 'idSDSS_frame';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'BZERO' => 'float',
		'BSCALE' => 'float',
		'TAI' => 'float',
		'RA' => 'float',
		'DEC' => 'float',
		'SPA' => 'float',
		'IPA' => 'float',
		'IPARATE' => 'float',
		'AZ' => 'float',
		'ALT' => 'float',
		'FOCUS' => 'float',
		'RUN' => 'int',
		'FRAME' => 'int',
		'CCDLOC' => 'int',
		'STRIPE' => 'int',
		'EQNX_SCN' => 'float',
		'NODE' => 'float',
		'INCL' => 'float',
		'XBORE' => 'float',
		'YBORE' => 'float',
		'C_OBS' => 'int',
		'COLBIN' => 'int',
		'ROWBIN' => 'int',
		'SCDWIDTH' => 'int',
		'SCDDECMF' => 'int',
		'SCDOFSET' => 'int',
		'SCDDYNTH' => 'int',
		'SCDSTTHL' => 'int',
		'SCDSTTHR' => 'int',
		'SCDREDSZ' => 'int',
		'SCDSKYL' => 'int',
		'SCDSKYR' => 'int',
		'CAMROW' => 'int',
		'BADLINES' => 'int',
		'EQUINOX' => 'int',
		'SOFTBIAS' => 'int',
		'CAMCOL' => 'int',
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
		'CD2_2' => 'float',
		'NMGY' => 'float',
		'NMGYIVAR' => 'float'
	];

	protected $dates = [
		'DATE-OBS',
		'TAIHMS'
	];

	protected $fillable = [
		'file_name',
		'band',
		'NAXIS1',
		'NAXIS2',
		'EXTEND',
		'BZERO',
		'BSCALE',
		'TAI',
		'RA',
		'DEC',
		'SPA',
		'IPA',
		'IPARATE',
		'AZ',
		'ALT',
		'FOCUS',
		'DATE-OBS',
		'TAIHMS',
		'ORIGIN',
		'TELESCOP',
		'TIMESYS',
		'RUN',
		'FRAME',
		'CCDLOC',
		'STRIPE',
		'STRIP',
		'FLAVOR',
		'OBSERVER',
		'SYS_SCN',
		'EQNX_SCN',
		'NODE',
		'INCL',
		'XBORE',
		'YBORE',
		'OBJECT',
		'EXPTIME',
		'SYSTEM',
		'CCDMODE',
		'C_OBS',
		'COLBIN',
		'ROWBIN',
		'DAVERS',
		'SCDMETHD',
		'SCDWIDTH',
		'SCDDECMF',
		'SCDOFSET',
		'SCDDYNTH',
		'SCDSTTHL',
		'SCDSTTHR',
		'SCDREDSZ',
		'SCDSKYL',
		'SCDSKYR',
		'CAMROW',
		'BADLINES',
		'EQUINOX',
		'SOFTBIAS',
		'BUNIT',
		'FILTER',
		'CAMCOL',
		'VERSION',
		'DERV_VER',
		'ASTR_VER',
		'ASTRO_ID',
		'BIAS_ID',
		'FRAME_ID',
		'KO_VER',
		'PS_ID',
		'ATVSN',
		'RADECSYS',
		'CTYPE1',
		'CTYPE2',
		'CUNIT1',
		'CUNIT2',
		'CRPIX1',
		'CRPIX2',
		'CRVAL1',
		'CRVAL2',
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2',
		'NMGY',
		'NMGYIVAR',
		'VERSIDL',
		'VERSUTIL',
		'VERSPOP',
		'RERUN'
	];
}
