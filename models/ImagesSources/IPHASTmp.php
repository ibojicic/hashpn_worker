<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 09 Jan 2017 07:13:00 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class IPHASTmp
 * 
 * @property int $idIPHAS
 * @property string $file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property string $EXTEND
 * @property \Carbon\Carbon $DATE
 * @property \Carbon\Carbon $IRAF-TLM
 * @property int $RUN
 * @property string $OBSERVAT
 * @property string $OBSERVER
 * @property string $OBJECT
 * @property float $LATITUDE
 * @property float $LONGITUD
 * @property float $HEIGHT
 * @property string $SLATEL
 * @property string $TELESCOP
 * @property float $MJD-OBS
 * @property float $JD
 * @property float $PLATESCA
 * @property float $TELFOCUS
 * @property float $AIRMASS
 * @property float $TEMPTUBE
 * @property string $INSTRUME
 * @property int $WFFPOS
 * @property string $WFFBAND
 * @property string $WFFID
 * @property float $SECPPIX
 * @property string $DETECTOR
 * @property string $CCDSPEED
 * @property int $CCDXBIN
 * @property int $CCDYBIN
 * @property string $CCDSUM
 * @property float $CCDTEMP
 * @property string $NWINDOWS
 * @property string $DATE_OBS
 * @property int $IMAGEID
 * @property int $DASCHAN
 * @property int $WINNO
 * @property string $CHIPNAME
 * @property string $CCDNAME
 * @property string $CCDCHIP
 * @property string $CCDTYPE
 * @property float $CCDXPIXE
 * @property float $CCDYPIXE
 * @property string $AMPNAME
 * @property float $GAIN
 * @property float $READNOIS
 * @property float $SATURATE
 * @property float $MAXBIAS
 * @property string $BIASSEC
 * @property string $TRIMSEC
 * @property string $RTDATSEC
 * @property string $RADESYS
 * @property string $EQUINOX
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property string $CRUNIT1
 * @property string $CRUNIT2
 * @property float $PV2_1
 * @property float $PV2_2
 * @property float $PV2_3
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property string $ZEROCOR
 * @property string $LINCOR
 * @property string $FLATCOR
 * @property string $CIR_CPM
 * @property string $CIR_DWIN
 * @property int $WCSPASS
 * @property int $NUMBRMS
 * @property float $STDCRMS
 * @property float $RAZP01
 * @property float $DECZP01
 * @property float $RAZP12
 * @property float $DECZP12
 * @property float $PERCORR
 * @property float $MAGZPT
 * @property float $MAGZRR
 * @property float $EXTINCT
 * @property float $NUMZPT
 * @property float $NIGHTZPT
 * @property float $NIGHTZRR
 * @property float $SEEING
 * @property int $NIGHTNUM
 * @property float $EXPTIME
 * @property float $PHOTZP
 * @property float $PHOTZPER
 * @property string $PHOTSYS
 * @property string $FLUXCAL
 * @property string $CONFMAP
 * @property string $CHECKSUM
 * @property string $DATASUM
 * @property int $WCSDIM
 * @property string $qcgrade
 * @property float $DRAJ2000
 * @property float $DDECJ2000
 *

 */
class IPHAS_tmp extends Eloquent
{
	protected $table = 'IPHAS_tmp';
	protected $primaryKey = 'idIPHAS';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'RUN' => 'int',
		'LATITUDE' => 'float',
		'LONGITUD' => 'float',
		'HEIGHT' => 'float',
		'MJD-OBS' => 'float',
		'JD' => 'float',
		'PLATESCA' => 'float',
		'TELFOCUS' => 'float',
		'AIRMASS' => 'float',
		'TEMPTUBE' => 'float',
		'WFFPOS' => 'int',
		'SECPPIX' => 'float',
		'CCDXBIN' => 'int',
		'CCDYBIN' => 'int',
		'CCDTEMP' => 'float',
		'IMAGEID' => 'int',
		'DASCHAN' => 'int',
		'WINNO' => 'int',
		'CCDXPIXE' => 'float',
		'CCDYPIXE' => 'float',
		'GAIN' => 'float',
		'READNOIS' => 'float',
		'SATURATE' => 'float',
		'MAXBIAS' => 'float',
		'PV2_1' => 'float',
		'PV2_2' => 'float',
		'PV2_3' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
		'CD2_2' => 'float',
		'WCSPASS' => 'int',
		'NUMBRMS' => 'int',
		'STDCRMS' => 'float',
		'RAZP01' => 'float',
		'DECZP01' => 'float',
		'RAZP12' => 'float',
		'DECZP12' => 'float',
		'PERCORR' => 'float',
		'MAGZPT' => 'float',
		'MAGZRR' => 'float',
		'EXTINCT' => 'float',
		'NUMZPT' => 'float',
		'NIGHTZPT' => 'float',
		'NIGHTZRR' => 'float',
		'SEEING' => 'float',
		'NIGHTNUM' => 'int',
		'EXPTIME' => 'float',
		'PHOTZP' => 'float',
		'PHOTZPER' => 'float',
		'WCSDIM' => 'int',
		'DRAJ2000' => 'float',
		'DDECJ2000' => 'float'
	];

	protected $dates = [
		'DATE',
		'IRAF-TLM'
	];

	protected $fillable = [
		'file_name',
		'band',
		'NAXIS1',
		'NAXIS2',
		'EXTEND',
		'DATE',
		'IRAF-TLM',
		'RUN',
		'OBSERVAT',
		'OBSERVER',
		'OBJECT',
		'LATITUDE',
		'LONGITUD',
		'HEIGHT',
		'SLATEL',
		'TELESCOP',
		'MJD-OBS',
		'JD',
		'PLATESCA',
		'TELFOCUS',
		'AIRMASS',
		'TEMPTUBE',
		'INSTRUME',
		'WFFPOS',
		'WFFBAND',
		'WFFID',
		'SECPPIX',
		'DETECTOR',
		'CCDSPEED',
		'CCDXBIN',
		'CCDYBIN',
		'CCDSUM',
		'CCDTEMP',
		'NWINDOWS',
		'DATE-OBS',
		'IMAGEID',
		'DASCHAN',
		'WINNO',
		'CHIPNAME',
		'CCDNAME',
		'CCDCHIP',
		'CCDTYPE',
		'CCDXPIXE',
		'CCDYPIXE',
		'AMPNAME',
		'GAIN',
		'READNOIS',
		'SATURATE',
		'MAXBIAS',
		'BIASSEC',
		'TRIMSEC',
		'RTDATSEC',
		'RADESYS',
		'EQUINOX',
		'CTYPE1',
		'CTYPE2',
		'CRUNIT1',
		'CRUNIT2',
		'PV2_1',
		'PV2_2',
		'PV2_3',
		'CRVAL1',
		'CRVAL2',
		'CRPIX1',
		'CRPIX2',
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2',
		'ZEROCOR',
		'LINCOR',
		'FLATCOR',
		'CIR_CPM',
		'CIR_DWIN',
		'WCSPASS',
		'NUMBRMS',
		'STDCRMS',
		'RAZP01',
		'DECZP01',
		'RAZP12',
		'DECZP12',
		'PERCORR',
		'MAGZPT',
		'MAGZRR',
		'EXTINCT',
		'NUMZPT',
		'NIGHTZPT',
		'NIGHTZRR',
		'SEEING',
		'NIGHTNUM',
		'EXPTIME',
		'PHOTZP',
		'PHOTZPER',
		'PHOTSYS',
		'FLUXCAL',
		'CONFMAP',
		'CHECKSUM',
		'DATASUM',
		'WCSDIM',
		'qcgrade',
		'DRAJ2000',
		'DDECJ2000'
	];
}
