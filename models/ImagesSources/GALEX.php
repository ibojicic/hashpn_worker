<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class GALEX
 * 
 * @property int $idGALEX
 * @property string $file_name
 * @property string $band
 * @property string $TILE
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $RA_CENT
 * @property float $DEC_CENT
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property float $CDELT1
 * @property float $CDELT2
 * @property int $SUBV0001
 * @property int $TILENUM
 * @property string $OBJECT
 * @property float $EQUINOX
 * @property float $EPOCH
 * @property int $OW
 * @property float $TWIST
 * @property int $LEG
 * @property int $MPSNPOS
 * @property float $EXPSTART
 * @property string $OBS-DATE
 * @property string $TIME-OBS
 * @property int $PLANID
 * @property string $TILENAME
 * @property string $MPSPLAN
 * @property string $MPSTYPE
 * @property string $MPSPHASE
 * @property int $SKYGRID
 * @property float $NHVNOM
 * @property float $NHVNOMN
 * @property float $NHVNOMF
 * @property string $GRELEASE
 * @property float $PHTFIRST
 * @property float $PHTLAST
 * @property float $EXPTIME
 * @property float $NGAPS
 * @property float $TOTREAD
 * @property float $TOTMAP
 * @property float $TOTONMAP
 * @property float $RRMED
 * @property float $RRAVE
 * @property float $NASPOK
 * @property float $AVEFDEAD
 * @property float $AVDE0001
 * @property float $AVFD0001
 * @property float $AVRA0001
 * @property float $AVRO0001
 * @property string $CALP0001
 * @property int $ECL0001
 * @property float $EXPEND
 * @property float $EXPT0001
 * @property float $GPA0001
 * @property string $GREL0001
 * @property string $HKF0001
 * @property float $NADDED
 * @property int $NASP0001
 * @property string $OBDT0001
 * @property float $OBSS0001
 * @property string $QAGR0001
 * @property float $ROLL0001
 * @property float $RRAV0001
 * @property float $RRMD0001
 * @property int $VIS0001
 * @property float $AVASPRA
 * @property float $AVASPDEC
 * @property float $AVASPROL
 * @property float $AVRRMED
 * @property float $AVRRAVE
 * @property float $PMEDRR
 * @property float $PTHRESH
 * @property float $PMEDBG
 * @property float $PRMSBG
 * @property float $PTHRBG
 * @property float $PSIGDET
 * @property float $PMEDTHR
 * @property float $PRMSTHR
 * @property int $WCSDIM
 * @property float $CD1_1
 * @property float $CD2_2
 * @property float $LTV1
 * @property float $LTV2
 * @property float $LTM1_1
 * @property float $LTM2_2
 * @property float $DRA
 * @property float $DDEC
 *

 */
class GALEX extends Eloquent
{
	protected $table = 'GALEX';
	protected $primaryKey = 'idGALEX';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'RA_CENT' => 'float',
		'DEC_CENT' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'CDELT1' => 'float',
		'CDELT2' => 'float',
		'SUBV0001' => 'int',
		'TILENUM' => 'int',
		'EQUINOX' => 'float',
		'EPOCH' => 'float',
		'OW' => 'int',
		'TWIST' => 'float',
		'LEG' => 'int',
		'MPSNPOS' => 'int',
		'EXPSTART' => 'float',
		'PLANID' => 'int',
		'SKYGRID' => 'int',
		'NHVNOM' => 'float',
		'NHVNOMN' => 'float',
		'NHVNOMF' => 'float',
		'PHTFIRST' => 'float',
		'PHTLAST' => 'float',
		'EXPTIME' => 'float',
		'NGAPS' => 'float',
		'TOTREAD' => 'float',
		'TOTMAP' => 'float',
		'TOTONMAP' => 'float',
		'RRMED' => 'float',
		'RRAVE' => 'float',
		'NASPOK' => 'float',
		'AVEFDEAD' => 'float',
		'AVDE0001' => 'float',
		'AVFD0001' => 'float',
		'AVRA0001' => 'float',
		'AVRO0001' => 'float',
		'ECL0001' => 'int',
		'EXPEND' => 'float',
		'EXPT0001' => 'float',
		'GPA0001' => 'float',
		'NADDED' => 'float',
		'NASP0001' => 'int',
		'OBSS0001' => 'float',
		'ROLL0001' => 'float',
		'RRAV0001' => 'float',
		'RRMD0001' => 'float',
		'VIS0001' => 'int',
		'AVASPRA' => 'float',
		'AVASPDEC' => 'float',
		'AVASPROL' => 'float',
		'AVRRMED' => 'float',
		'AVRRAVE' => 'float',
		'PMEDRR' => 'float',
		'PTHRESH' => 'float',
		'PMEDBG' => 'float',
		'PRMSBG' => 'float',
		'PTHRBG' => 'float',
		'PSIGDET' => 'float',
		'PMEDTHR' => 'float',
		'PRMSTHR' => 'float',
		'WCSDIM' => 'int',
		'CD1_1' => 'float',
		'CD2_2' => 'float',
		'LTV1' => 'float',
		'LTV2' => 'float',
		'LTM1_1' => 'float',
		'LTM2_2' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'TILE',
		'CTYPE1',
		'CTYPE2',
		'CRPIX1',
		'CRPIX2',
		'CRVAL1',
		'CRVAL2',
		'RA_CENT',
		'DEC_CENT',
		'NAXIS1',
		'NAXIS2',
		'CDELT1',
		'CDELT2',
		'SUBV0001',
		'TILENUM',
		'OBJECT',
		'EQUINOX',
		'EPOCH',
		'OW',
		'TWIST',
		'LEG',
		'MPSNPOS',
		'EXPSTART',
		'OBS-DATE',
		'TIME-OBS',
		'PLANID',
		'TILENAME',
		'MPSPLAN',
		'MPSTYPE',
		'MPSPHASE',
		'SKYGRID',
		'NHVNOM',
		'NHVNOMN',
		'NHVNOMF',
		'GRELEASE',
		'PHTFIRST',
		'PHTLAST',
		'EXPTIME',
		'NGAPS',
		'TOTREAD',
		'TOTMAP',
		'TOTONMAP',
		'RRMED',
		'RRAVE',
		'NASPOK',
		'AVEFDEAD',
		'AVDE0001',
		'AVFD0001',
		'AVRA0001',
		'AVRO0001',
		'CALP0001',
		'ECL0001',
		'EXPEND',
		'EXPT0001',
		'GPA0001',
		'GREL0001',
		'HKF0001',
		'NADDED',
		'NASP0001',
		'OBDT0001',
		'OBSS0001',
		'QAGR0001',
		'ROLL0001',
		'RRAV0001',
		'RRMD0001',
		'VIS0001',
		'AVASPRA',
		'AVASPDEC',
		'AVASPROL',
		'AVRRMED',
		'AVRRAVE',
		'PMEDRR',
		'PTHRESH',
		'PMEDBG',
		'PRMSBG',
		'PTHRBG',
		'PSIGDET',
		'PMEDTHR',
		'PRMSTHR',
		'WCSDIM',
		'CD1_1',
		'CD2_2',
		'LTV1',
		'LTV2',
		'LTM1_1',
		'LTM2_2',
        'DRA',
        'DDEC'
	];
}
