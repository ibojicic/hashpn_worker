<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class VMC
 * 
 * @property int $idVMC
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
 * @property int $VSA_MFID
 * @property string $OBSTATUS
 * @property string $ESOGRADE
 * @property float $RA_CENT
 * @property float $DEC_CENT
 *

 */
class VMC extends Eloquent
{
	protected $table = 'VMC';
	protected $primaryKey = 'idVMC';
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
		'VSA_MFID' => 'int',
		'RA_CENT' => 'float',
		'DEC_CENT' => 'float'
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
		'VSA_MFID',
		'OBSTATUS',
		'ESOGRADE',
		'RA_CENT',
		'DEC_CENT'
	];
}
