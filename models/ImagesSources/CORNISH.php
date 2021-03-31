<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CORNISH
 * 
 * @property int $idCORNISH
 * @property string $file_name
 * @property string $band
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property string $CTYPE3
 * @property string $CTYPE4
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRPIX3
 * @property float $CRPIX4
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $CRVAL3
 * @property float $CRVAL4
 * @property string $BUNIT
 * @property string $OBJECT
 * @property float $CDELT1
 * @property float $CDELT2
 * @property float $CDELT3
 * @property float $CDELT4
 * @property float $DATAMAX
 * @property float $DATAMIN
 * @property float $CROTA1
 * @property float $CROTA2
 * @property float $CROTA3
 * @property float $CROTA4
 * @property string $OBSERVER
 * @property float $EPOCH
 * @property float $EQUINOX
 * @property float $ALTRPIX
 * @property float $CLEANBMJ
 * @property float $CLEANBMN
 * @property float $CLEANBPA
 * @property float $BMAJ
 * @property float $BMIN
 * @property float $BPA
 *

 */
class CORNISH extends Eloquent
{
	protected $table = 'CORNISH';
	protected $primaryKey = 'idCORNISH';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRPIX3' => 'float',
		'CRPIX4' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'CRVAL3' => 'float',
		'CRVAL4' => 'float',
		'CDELT1' => 'float',
		'CDELT2' => 'float',
		'CDELT3' => 'float',
		'CDELT4' => 'float',
		'DATAMAX' => 'float',
		'DATAMIN' => 'float',
		'CROTA1' => 'float',
		'CROTA2' => 'float',
		'CROTA3' => 'float',
		'CROTA4' => 'float',
		'EPOCH' => 'float',
		'EQUINOX' => 'float',
		'ALTRPIX' => 'float',
		'CLEANBMJ' => 'float',
		'CLEANBMN' => 'float',
		'CLEANBPA' => 'float',
		'BMAJ' => 'float',
		'BMIN' => 'float',
		'BPA' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'NAXIS1',
		'NAXIS2',
		'CTYPE1',
		'CTYPE2',
		'CTYPE3',
		'CTYPE4',
		'CRPIX1',
		'CRPIX2',
		'CRPIX3',
		'CRPIX4',
		'CRVAL1',
		'CRVAL2',
		'CRVAL3',
		'CRVAL4',
		'BUNIT',
		'OBJECT',
		'CDELT1',
		'CDELT2',
		'CDELT3',
		'CDELT4',
		'DATAMAX',
		'DATAMIN',
		'CROTA1',
		'CROTA2',
		'CROTA3',
		'CROTA4',
		'OBSERVER',
		'EPOCH',
		'EQUINOX',
		'ALTRPIX',
		'CLEANBMJ',
		'CLEANBMN',
		'CLEANBPA',
		'BMAJ',
		'BMIN',
		'BPA'
	];
}
