<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class WISE
 * 
 * @property int $idWISE
 * @property string $file_name
 * @property string $band
 * @property float $WAVELEN
 * @property string $COADDID
 * @property float $MAGZP
 * @property float $MAGZPUNC
 * @property float $PXSCAL1
 * @property float $PXSCAL2
 * @property float $MEDINT
 * @property float $MEDCOV
 * @property float $MINCOV
 * @property float $MAXCOV
 * @property float $ROBSIG
 * @property float $PIXCHIS1
 * @property float $PIXCHIS2
 * @property float $ELON
 * @property float $ELAT
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $GLON
 * @property float $GLAT
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property float $SIZEX
 * @property float $SIZEY
 * @property string $BUNIT
 * @property float $CDELT1
 * @property float $CDELT2
 * @property string $DATEOBS1
 * @property string $DATEOBS2
 * @property float $DRA
 * @property float $DDEC
 *

 */
class WISE extends Eloquent
{
	protected $table = 'WISE';
	protected $primaryKey = 'idWISE';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'WAVELEN' => 'float',
		'MAGZP' => 'float',
		'MAGZPUNC' => 'float',
		'PXSCAL1' => 'float',
		'PXSCAL2' => 'float',
		'MEDINT' => 'float',
		'MEDCOV' => 'float',
		'MINCOV' => 'float',
		'MAXCOV' => 'float',
		'ROBSIG' => 'float',
		'PIXCHIS1' => 'float',
		'PIXCHIS2' => 'float',
		'ELON' => 'float',
		'ELAT' => 'float',
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'GLON' => 'float',
		'GLAT' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'SIZEX' => 'float',
		'SIZEY' => 'float',
		'CDELT1' => 'float',
		'CDELT2' => 'float',
		'DRA' => 'float',
		'DDEC' => 'float'
	];

	protected $fillable = [
		'file_name',
		'band',
		'WAVELEN',
		'COADDID',
		'MAGZP',
		'MAGZPUNC',
		'PXSCAL1',
		'PXSCAL2',
		'MEDINT',
		'MEDCOV',
		'MINCOV',
		'MAXCOV',
		'ROBSIG',
		'PIXCHIS1',
		'PIXCHIS2',
		'ELON',
		'ELAT',
		'CTYPE1',
		'CTYPE2',
		'CRPIX1',
		'CRPIX2',
		'CRVAL1',
		'CRVAL2',
		'GLON',
		'GLAT',
		'NAXIS1',
		'NAXIS2',
		'SIZEX',
		'SIZEY',
		'BUNIT',
		'CDELT1',
		'CDELT2',
		'DATEOBS1',
		'DATEOBS2',
		'DRA',
		'DDEC'
	];
}
