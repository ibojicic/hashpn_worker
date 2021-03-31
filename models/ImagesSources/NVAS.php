<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class NVA
 * 
 * @property int $idNVAS
 * @property string $file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property int $NAXIS3
 * @property int $NAXIS4
 * @property string $OBJECT
 * @property string $TELESCOP
 * @property string $INSTRUME
 * @property string $OBSERVER
 * @property string $DATE_OBS
 * @property string $DATE_MAP
 * @property float $BSCALE
 * @property float $BZERO
 * @property string $BUNIT
 * @property float $EPOCH
 * @property float $BLANK
 * @property float $VELREF
 * @property float $ALTRPIX
 * @property float $OBSRA
 * @property float $OBSDEC
 * @property float $DATAMAX
 * @property float $DATAMIN
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property string $CTYPE3
 * @property string $CTYPE4
 * @property string $CDELT1
 * @property float $CDELT2
 * @property float $CDELT3
 * @property float $CDELT4
 * @property string $CRPIX1
 * @property float $CRPIX2
 * @property float $CRPIX3
 * @property float $CRPIX4
 * @property string $CROTA1
 * @property float $CROTA2
 * @property float $CROTA3
 * @property float $CROTA4
 * @property string $ORIGIN
 * @property string $DATE
 * @property string $FILTER
 *

 */
class NVAS extends Eloquent
{
    protected $table = 'NVAS';
    protected $primaryKey = 'idNVAS';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'NAXIS3' => 'int',
		'NAXIS4' => 'int',
		'BSCALE' => 'float',
		'BZERO' => 'float',
		'EPOCH' => 'float',
		'BLANK' => 'float',
		'VELREF' => 'float',
		'ALTRPIX' => 'float',
		'OBSRA' => 'float',
		'OBSDEC' => 'float',
		'DATAMAX' => 'float',
		'DATAMIN' => 'float',
		'CDELT2' => 'float',
		'CDELT3' => 'float',
		'CDELT4' => 'float',
		'CRPIX2' => 'float',
		'CRPIX3' => 'float',
		'CRPIX4' => 'float',
		'CROTA2' => 'float',
		'CROTA3' => 'float',
		'CROTA4' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'NAXIS1',
		'NAXIS2',
		'NAXIS3',
		'NAXIS4',
		'OBJECT',
		'TELESCOP',
		'INSTRUME',
		'OBSERVER',
		'DATE-OBS',
		'DATE-MAP',
		'BSCALE',
		'BZERO',
		'BUNIT',
		'EPOCH',
		'BLANK',
		'VELREF',
		'ALTRPIX',
		'OBSRA',
		'OBSDEC',
		'DATAMAX',
		'DATAMIN',
		'CTYPE1',
		'CTYPE2',
		'CTYPE3',
		'CTYPE4',
		'CDELT1',
		'CDELT2',
		'CDELT3',
		'CDELT4',
		'CRPIX1',
		'CRPIX2',
		'CRPIX3',
		'CRPIX4',
		'CROTA1',
		'CROTA2',
		'CROTA3',
		'CROTA4',
		'ORIGIN',
		'DATE',
		'FILTER'
	];
}
