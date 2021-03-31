<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class IRA
 * 
 * @property int $idIRAS
 * @property string $file_name
 * @property string $band
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property string $CTYPE3
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRPIX3
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $CRVAL3
 * @property float $CDELT1
 * @property float $CDELT2
 * @property float $CDELT3
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property int $NAXIS3
 * @property string $BUNIT
 * @property string $OBJECT
 * @property float $DATAMAX
 * @property float $DATAMIN
 * @property float $EPOCH
 * @property string $ORIGIN
 * @property string $TELESCOP
 * @property string $INSTRUME
 * @property float $DRA
 * @property float $DDEC
 *

 */
class IRAS extends Eloquent
{
    protected $table = 'IRAS';
    protected $primaryKey = 'idIRAS';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRPIX3' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'CRVAL3' => 'float',
		'CDELT1' => 'float',
		'CDELT2' => 'float',
		'CDELT3' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'NAXIS3' => 'int',
		'DATAMAX' => 'float',
		'DATAMIN' => 'float',
		'EPOCH' => 'float',
		'DRA' => 'float',
		'DDEC' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'CTYPE1',
		'CTYPE2',
		'CTYPE3',
		'CRPIX1',
		'CRPIX2',
		'CRPIX3',
		'CRVAL1',
		'CRVAL2',
		'CRVAL3',
		'CDELT1',
		'CDELT2',
		'CDELT3',
		'NAXIS1',
		'NAXIS2',
		'NAXIS3',
		'BUNIT',
		'OBJECT',
		'DATAMAX',
		'DATAMIN',
		'EPOCH',
		'ORIGIN',
		'TELESCOP',
		'INSTRUME',
		'DRA',
		'DDEC'
	];
}
