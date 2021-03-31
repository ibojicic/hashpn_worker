<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MIPSGAL70
 * 
 * @property int $idMIPSGAL70
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
 * @property int $CHNLNUM
 * @property string $DATE_OBS
 * @property string $BUNIT
 * @property float $EXPTIME
 * @property float $FLUXCONV
 * @property string $AOT_TYPE
 * @property string $AORLABEL
 * @property string $REQTYPE
 * @property string $EXPTYPE
 * @property string $PRODTYPE
 * @property int $PRIMEARR
 * @property string $OBSRVR
 * @property int $OBSRVRID
 * @property int $PROCYCL
 * @property int $PROGID
 * @property string $PROTITLE
 * @property float $SAMPTIME
 * @property string $OBJECT
 * @property string $OBJTYPE
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property float $PXSCAL1
 * @property float $PXSCAL2
 * @property float $PA
 * @property float $RA_REF
 * @property float $DEC_REF
 * @property float $NOMWAVE
 * @property float $FILTWDTH
 * @property float $ZODIMIN
 * @property float $ZODIMAX
 * @property float $ZODIMED
 * @property string $WARMFLAG
 *

 */
class MIPSGAL70 extends Eloquent
{
	protected $table = 'MIPSGAL70';
	protected $primaryKey = 'idMIPSGAL70';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'CHNLNUM' => 'int',
		'EXPTIME' => 'float',
		'FLUXCONV' => 'float',
		'PRIMEARR' => 'int',
		'OBSRVRID' => 'int',
		'PROCYCL' => 'int',
		'PROGID' => 'int',
		'SAMPTIME' => 'float',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
		'CD2_2' => 'float',
		'PXSCAL1' => 'float',
		'PXSCAL2' => 'float',
		'PA' => 'float',
		'RA_REF' => 'float',
		'DEC_REF' => 'float',
		'NOMWAVE' => 'float',
		'FILTWDTH' => 'float',
		'ZODIMIN' => 'float',
		'ZODIMAX' => 'float',
		'ZODIMED' => 'float'
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
		'CHNLNUM',
		'DATE_OBS',
		'BUNIT',
		'EXPTIME',
		'FLUXCONV',
		'AOT_TYPE',
		'AORLABEL',
		'REQTYPE',
		'EXPTYPE',
		'PRODTYPE',
		'PRIMEARR',
		'OBSRVR',
		'OBSRVRID',
		'PROCYCL',
		'PROGID',
		'PROTITLE',
		'SAMPTIME',
		'OBJECT',
		'OBJTYPE',
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2',
		'PXSCAL1',
		'PXSCAL2',
		'PA',
		'RA_REF',
		'DEC_REF',
		'NOMWAVE',
		'FILTWDTH',
		'ZODIMIN',
		'ZODIMAX',
		'ZODIMED',
		'WARMFLAG'
	];
}
