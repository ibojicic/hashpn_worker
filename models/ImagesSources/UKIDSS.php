<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class UKIDSS
 * 
 * @property int $idUKIDSS
 * @property string $file_name
 * @property string $band
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property string $NAXIS1
 * @property int $NAXIS2
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property float $PIXLSIZE
 * @property float $SKYLEVEL
 * @property float $SKYNOISE
 * @property float $SEEING
 * @property float $MAGZPT
 * @property float $MAGZRR
 * @property float $EXTINCT
 * @property int $CAMNUM
 * @property string $SDSUID
 * @property string $RUNID
 * @property float $CIRMED
 * @property float $CIR_BVAR
 * @property string $OBSID
 * @property string $origpath
 * @property string $flag
 * @property float $DRA
 * @property float $DDEC
 *

 */
class UKIDSS extends Eloquent
{
	protected $table = 'UKIDSS';
	protected $primaryKey = 'idUKIDSS';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'NAXIS2' => 'int',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
		'CD2_2' => 'float',
		'PIXLSIZE' => 'float',
		'SKYLEVEL' => 'float',
		'SKYNOISE' => 'float',
		'SEEING' => 'float',
		'MAGZPT' => 'float',
		'MAGZRR' => 'float',
		'EXTINCT' => 'float',
		'RA_CENT' => 'float',
		'DEC_CENT' => 'float',
		'CAMNUM' => 'int',
		'CIRMED' => 'float',
		'CIR_BVAR' => 'float'
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
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2',
		'PIXLSIZE',
		'SKYLEVEL',
		'SKYNOISE',
		'SEEING',
		'MAGZPT',
		'MAGZRR',
		'EXTINCT',
		'CAMNUM',
		'SDSUID',
		'RUNID',
		'CIRMED',
		'CIR_BVAR',
		'OBSID',
		'origpath',
		'flag',
        'DRA',
		'DDEC'

	];
}
