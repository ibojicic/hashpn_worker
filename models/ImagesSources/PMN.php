<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PMN
 * 
 * @property int $idPMN
 * @property string $file_name
 * @property string $band
 * @property string $OBJECT
 * @property string $TELESCOP
 * @property string $INSTRUME
 * @property string $OBSERVER
 * @property string $DATE_OBS
 * @property string $DATE_MAP
 * @property float $BSCALE
 * @property float $BZERO
 * @property string $BUNIT
 * @property float $DATAMAX
 * @property float $DATAMIN
 * @property string $CTYPE1
 * @property float $CRVAL1
 * @property float $CDELT1
 * @property float $CRPIX1
 * @property float $CROTA1
 * @property string $CTYPE2
 * @property float $CRVAL2
 * @property float $CDELT2
 * @property float $CRPIX2
 * @property float $CROTA2
 * @property string $CTYPE3
 * @property float $CRVAL3
 * @property float $CDELT3
 * @property float $CRPIX3
 * @property float $CROTA3
 * @property string $CTYPE4
 * @property float $CRVAL4
 * @property float $CDELT4
 * @property float $CRPIX4
 * @property float $CROTA4
 * @property int $NAXIS1
 * @property int $NAXIS2
 *

 */
class PMN extends Eloquent
{
	protected $table = 'PMN';
	protected $primaryKey = 'idPMN';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'BSCALE' => 'float',
		'BZERO' => 'float',
		'DATAMAX' => 'float',
		'DATAMIN' => 'float',
		'CRVAL1' => 'float',
		'CDELT1' => 'float',
		'CRPIX1' => 'float',
		'CROTA1' => 'float',
		'CRVAL2' => 'float',
		'CDELT2' => 'float',
		'CRPIX2' => 'float',
		'CROTA2' => 'float',
		'CRVAL3' => 'float',
		'CDELT3' => 'float',
		'CRPIX3' => 'float',
		'CROTA3' => 'float',
		'CRVAL4' => 'float',
		'CDELT4' => 'float',
		'CRPIX4' => 'float',
		'CROTA4' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int'
	];

	protected $fillable = [
		'file_name',
		'band',
		'OBJECT',
		'TELESCOP',
		'INSTRUME',
		'OBSERVER',
		'DATE-OBS',
		'DATE-MAP',
		'BSCALE',
		'BZERO',
		'BUNIT',
		'DATAMAX',
		'DATAMIN',
		'CTYPE1',
		'CRVAL1',
		'CDELT1',
		'CRPIX1',
		'CROTA1',
		'CTYPE2',
		'CRVAL2',
		'CDELT2',
		'CRPIX2',
		'CROTA2',
		'CTYPE3',
		'CRVAL3',
		'CDELT3',
		'CRPIX3',
		'CROTA3',
		'CTYPE4',
		'CRVAL4',
		'CDELT4',
		'CRPIX4',
		'CROTA4',
		'NAXIS1',
		'NAXIS2'
	];
}
