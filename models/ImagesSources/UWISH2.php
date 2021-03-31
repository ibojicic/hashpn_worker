<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class UWISH2
 * 
 * @property int $idUWISH2
 * @property string $file_name
 * @property string $band
 * @property float $DRA
 * @property float $DDEC
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property int $PCOUNT
 * @property int $GCOUNT
 * @property string $EXTNAME
 * @property int $CAMNUM
 * @property string $HDTFILE2
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property string $CRUNIT1
 * @property string $CRUNIT2
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property float $PV2_1
 * @property float $PV2_2
 * @property float $PV2_3
 * @property string $DETECTOR
 * @property string $DETECTID
 * @property int $DROWS
 * @property int $DCOLUMNS
 * @property int $RDOUT_X1
 * @property int $RDOUT_X2
 * @property int $RDOUT_Y1
 * @property int $RDOUT_Y2
 * @property float $PIXLSIZE
 * @property string $PCSYSID
 * @property string $SDSUID
 * @property string $CAPPLICN
 * @property string $CAMROLE
 * @property string $CAMPOWER
 * @property string $RUNID
 * @property string $READOUT
 * @property float $GAIN
 * @property float $DET_TEMP
 * @property float $CNFINDEX
 * @property float $READNOIS
 * @property string $DARKCOR
 * @property string $FLATCOR
 * @property string $CIR_CPM
 * @property string $CIR_VERS
 * @property string $DECURTN
 * @property float $CURTNRNG
 * @property string $XTALK
 * @property string $SKYSUB
 * @property string $PARQCOR
 * @property float $CIR_XOFF
 * @property float $CIR_YOFF
 * @property float $CIRMED
 * @property float $CIR_BVAR
 * @property float $CIR_ZERO
 * @property float $CIR_SCAL
 * @property float $SKYLEVEL
 * @property float $SKYNOISE
 * @property string $PROV0000
 * @property string $PROV0001
 * @property string $PROV0002
 * @property string $PROV0003
 * @property float $SEEING
 * @property float $NUMBRMS
 * @property float $STDCRMS
 * @property int $WCSPASS
 * @property float $RAZP02
 * @property float $DECZP02
 * @property float $ELLIPTIC
 * @property float $MAGZPT
 * @property float $MAGZRR
 * @property float $EXTINCT
 * @property float $PERCORR
 * @property float $PROJP1
 * @property float $PROJP3
 * @property float $PROJP5
 * @property float $PV2_5
 * @property int $NUMZPT
 * @property float $NIGHTZPT
 * @property float $NIGHTZRR
 * @property int $NIGHTNUM
 * @property float $BSCALE
 *

 */
class UWISH2 extends Eloquent
{
	protected $table = 'UWISH2';
	protected $primaryKey = 'idUWISH2';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'DRA' => 'float',
		'DDEC' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'PCOUNT' => 'int',
		'GCOUNT' => 'int',
		'CAMNUM' => 'int',
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
		'CD2_2' => 'float',
		'PV2_1' => 'float',
		'PV2_2' => 'float',
		'PV2_3' => 'float',
		'DROWS' => 'int',
		'DCOLUMNS' => 'int',
		'RDOUT_X1' => 'int',
		'RDOUT_X2' => 'int',
		'RDOUT_Y1' => 'int',
		'RDOUT_Y2' => 'int',
		'PIXLSIZE' => 'float',
		'GAIN' => 'float',
		'DET_TEMP' => 'float',
		'CNFINDEX' => 'float',
		'READNOIS' => 'float',
		'CURTNRNG' => 'float',
		'CIR_XOFF' => 'float',
		'CIR_YOFF' => 'float',
		'CIRMED' => 'float',
		'CIR_BVAR' => 'float',
		'CIR_ZERO' => 'float',
		'CIR_SCAL' => 'float',
		'SKYLEVEL' => 'float',
		'SKYNOISE' => 'float',
		'SEEING' => 'float',
		'NUMBRMS' => 'float',
		'STDCRMS' => 'float',
		'WCSPASS' => 'int',
		'RAZP02' => 'float',
		'DECZP02' => 'float',
		'ELLIPTIC' => 'float',
		'MAGZPT' => 'float',
		'MAGZRR' => 'float',
		'EXTINCT' => 'float',
		'PERCORR' => 'float',
		'PROJP1' => 'float',
		'PROJP3' => 'float',
		'PROJP5' => 'float',
		'PV2_5' => 'float',
		'NUMZPT' => 'int',
		'NIGHTZPT' => 'float',
		'NIGHTZRR' => 'float',
		'NIGHTNUM' => 'int',
		'BSCALE' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'DRA',
		'DDEC',
		'NAXIS1',
		'NAXIS2',
		'PCOUNT',
		'GCOUNT',
		'EXTNAME',
		'CAMNUM',
		'HDTFILE2',
		'CTYPE1',
		'CTYPE2',
		'CRPIX1',
		'CRPIX2',
		'CRVAL1',
		'CRVAL2',
		'CRUNIT1',
		'CRUNIT2',
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2',
		'PV2_1',
		'PV2_2',
		'PV2_3',
		'DETECTOR',
		'DETECTID',
		'DROWS',
		'DCOLUMNS',
		'RDOUT_X1',
		'RDOUT_X2',
		'RDOUT_Y1',
		'RDOUT_Y2',
		'PIXLSIZE',
		'PCSYSID',
		'SDSUID',
		'CAPPLICN',
		'CAMROLE',
		'CAMPOWER',
		'RUNID',
		'READOUT',
		'GAIN',
		'DET_TEMP',
		'CNFINDEX',
		'READNOIS',
		'DARKCOR',
		'FLATCOR',
		'CIR_CPM',
		'CIR_VERS',
		'DECURTN',
		'CURTNRNG',
		'XTALK',
		'SKYSUB',
		'PARQCOR',
		'CIR_XOFF',
		'CIR_YOFF',
		'CIRMED',
		'CIR_BVAR',
		'CIR_ZERO',
		'CIR_SCAL',
		'SKYLEVEL',
		'SKYNOISE',
		'PROV0000',
		'PROV0001',
		'PROV0002',
		'PROV0003',
		'SEEING',
		'NUMBRMS',
		'STDCRMS',
		'WCSPASS',
		'RAZP02',
		'DECZP02',
		'ELLIPTIC',
		'MAGZPT',
		'MAGZRR',
		'EXTINCT',
		'PERCORR',
		'PROJP1',
		'PROJP3',
		'PROJP5',
		'PV2_5',
		'NUMZPT',
		'NIGHTZPT',
		'NIGHTZRR',
		'NIGHTNUM',
		'BSCALE'
	];
}
