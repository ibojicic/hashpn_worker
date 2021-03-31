<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class LMCMCEL
 * 
 * @property int $idLMC_MCELS
 * @property string $file_name
 * @property string $band
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property string $RA
 * @property string $DEC
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property float $IRAF_MAX
 * @property float $IRAF_MIN
 * @property string $DATE-OBS
 * @property string $UT
 * @property float $ZD
 * @property string $HA
 * @property string $ST
 * @property float $AIRMASS
 * @property float $XPIXSIZE
 * @property float $YPIXSIZE
 * @property float $CDELT1
 * @property float $CDELT2
 *

 */
class LMC_MCELS extends Eloquent
{
    protected $table = 'LMC_MCELS';
    protected $primaryKey = 'idLMC_MCELS';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'IRAF-MAX' => 'float',
		'IRAF-MIN' => 'float',
		'ZD' => 'float',
		'AIRMASS' => 'float',
		'XPIXSIZE' => 'float',
		'YPIXSIZE' => 'float',
		'CDELT1' => 'float',
		'CDELT2' => 'float'
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
		'RA',
		'DEC',
		'NAXIS1',
		'NAXIS2',
		'IRAF-MAX',
		'IRAF-MIN',
		'DATE-OBS',
		'UT',
		'ZD',
		'HA',
		'ST',
		'AIRMASS',
		'XPIXSIZE',
		'YPIXSIZE',
		'CDELT1',
		'CDELT2'
	];
}
