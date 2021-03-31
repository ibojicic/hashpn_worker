<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class SHSMC
 * 
 * @property int $idSHS_MC
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
 * @property int $PLATENUM
 * @property string $FILTER
 * @property float $PLTSCALE
 * @property int $FIELDNUM
 * @property \Carbon\Carbon $DATE_OBS
 * @property string $INSTRUME
 * @property \Carbon\Carbon $DATE_MES
 * @property float $XPIXELSZ
 * @property float $YPIXELSZ
 * @property string $OBJCTRA
 * @property string $OBJCTDEC
 * @property float $OBJCTX
 * @property float $OBJCTY
 * @property float $DATAMINI
 * @property float $DATAMAXI
 * @property float $DATAMEDI
 * @property float $DATAMODE
 * @property float $FLATFLD
 *

 */
class SHS_MC extends Eloquent
{
	protected $table = 'SHS_MC';
	protected $primaryKey = 'idSHS_MC';
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
		'PLATENUM' => 'int',
		'PLTSCALE' => 'float',
		'FIELDNUM' => 'int',
		'XPIXELSZ' => 'float',
		'YPIXELSZ' => 'float',
		'OBJCTX' => 'float',
		'OBJCTY' => 'float',
		'DATAMINI' => 'float',
		'DATAMAXI' => 'float',
		'DATAMEDI' => 'float',
		'DATAMODE' => 'float',
		'FLATFLD' => 'float'
	];

	protected $dates = [
		'DATE-OBS',
		'DATE-MES'
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
		'PLATENUM',
		'FILTER',
		'PLTSCALE',
		'FIELDNUM',
		'DATE-OBS',
		'INSTRUME',
		'DATE-MES',
		'XPIXELSZ',
		'YPIXELSZ',
		'OBJCTRA',
		'OBJCTDEC',
		'OBJCTX',
		'OBJCTY',
		'DATAMINI',
		'DATAMAXI',
		'DATAMEDI',
		'DATAMODE',
		'FLATFLD'
	];
}
