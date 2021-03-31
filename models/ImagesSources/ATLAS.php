<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */
namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class ATLAS
 * 
 * @property int $idATLAS
 * @property string $file_name
 * @property string $original_file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property string $DATE
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $CD1_1
 * @property float $CD2_1
 * @property float $CD1_2
 * @property float $CD2_2
 * @property string $ZHECKSUM
 * @property string $ZDATASUM
 * @property string $BIASCOR
 * @property string $BIASSRC
 * @property string $OVERSCAN
 * @property string $FLATCOR
 * @property string $FLATSRC
 * @property float $GAINCOR
 * @property string $CIR_CPM
 * @property float $SKYLEVEL
 * @property float $SKYNOISE
 * @property string $CIR_VERS
 * @property float $SEEING
 * @property float $ELLIPTIC
 * @property int $NUMSTDS
 * @property float $RAZP02
 * @property float $DECZP02
 * @property int $NICOMB
 * @property int $NUMBRMS
 * @property float $STDCRMS
 * @property int $WCSPASS
 * @property float $BSCALE
 * @property float $MAGZPT
 * @property float $MAGZRR
 * @property float $EXTINCT
 * @property int $CAMNUM
 * @property float $DRA
 * @property float $DDEC
 *

 */
class ATLAS extends Eloquent
{
    protected $table = 'ATLAS';
    protected $primaryKey = 'idATLAS';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'CD1_1' => 'float',
		'CD2_1' => 'float',
		'CD1_2' => 'float',
		'CD2_2' => 'float',
		'GAINCOR' => 'float',
		'SKYLEVEL' => 'float',
		'SKYNOISE' => 'float',
		'SEEING' => 'float',
		'ELLIPTIC' => 'float',
		'NUMSTDS' => 'int',
		'RAZP02' => 'float',
		'DECZP02' => 'float',
		'NICOMB' => 'int',
		'NUMBRMS' => 'int',
		'STDCRMS' => 'float',
		'WCSPASS' => 'int',
		'BSCALE' => 'float',
		'MAGZPT' => 'float',
		'MAGZRR' => 'float',
		'EXTINCT' => 'float',
		'CAMNUM' => 'int',
		'DRA' => 'float',
		'DDEC' => 'float'
	];

	protected $fillable = [
		'file_name',
		'original_file_name',
		'band',
		'NAXIS1',
		'NAXIS2',
		'DATE',
		'CTYPE1',
		'CTYPE2',
		'CRPIX1',
		'CRPIX2',
		'CRVAL1',
		'CRVAL2',
		'CD1_1',
		'CD2_1',
		'CD1_2',
		'CD2_2',
		'ZHECKSUM',
		'ZDATASUM',
		'BIASCOR',
		'BIASSRC',
		'OVERSCAN',
		'FLATCOR',
		'FLATSRC',
		'GAINCOR',
		'CIR_CPM',
		'SKYLEVEL',
		'SKYNOISE',
		'CIR_VERS',
		'SEEING',
		'ELLIPTIC',
		'NUMSTDS',
		'RAZP02',
		'DECZP02',
		'NICOMB',
		'NUMBRMS',
		'STDCRMS',
		'WCSPASS',
		'BSCALE',
		'MAGZPT',
		'MAGZRR',
		'EXTINCT',
		'CAMNUM',
		'DRA',
		'DDEC'
	];
}
