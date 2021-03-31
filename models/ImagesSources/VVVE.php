<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class VVVE
 * 
 * @property int $idVVVE
 * @property string $file_name
 * @property string $band
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property float $RA
 * @property float $DEC
 * @property string $OBJECT
 * @property string $INSTRUME
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property string $DATE-OBS
 * @property float $UTC
 * @property float $LST
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property int $OBSNUM
 * @property string $OBSTATUS
 * @property string $ESOGRADE
 * @property float $DRA
 * @property float $DDEC
 * @property string $VSA_MFID
 * @property string $origpath
 * @property string $flag
 *

 */
class VVVE extends Eloquent
{
	protected $table = 'VVVE';
	protected $primaryKey = 'idVVVE';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'RA' => 'float',
		'DEC' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'UTC' => 'float',
		'LST' => 'float',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
		'CD2_2' => 'float',
		'OBSNUM' => 'int',
		'DRA' => 'float',
		'DDEC' => 'float'
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
		'OBJECT',
		'INSTRUME',
		'NAXIS1',
		'NAXIS2',
		'DATE-OBS',
		'UTC',
		'LST',
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2',
		'OBSNUM',
		'OBSTATUS',
		'ESOGRADE',
		'DRA',
		'DDEC',
		'VSA_MFID',
		'origpath',
		'flag'
	];
}
