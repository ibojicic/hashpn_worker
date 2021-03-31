<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MSX
 *
 * @property  integer $idMSX
 * @property  string $file_name
 * @property  string $band
 * @property  string $CTYPE1
 * @property  string $CTYPE2
 * @property  string $CTYPE3
 * @property  float $CRPIX1
 * @property  float $CRPIX2
 * @property  float $CRPIX3
 * @property  float $CRVAL1
 * @property  float $CRVAL2
 * @property  float $CRVAL3
 * @property  integer $NAXIS1
 * @property  integer $NAXIS2
 * @property  string $BUNIT
 * @property  float $CDELT1
 * @property  float $CDELT2
 * @property  float $CDELT3
 * @property  float $CROTA2
 * @property  float $LONPOLE
 * @property  float $CD1_1
 * @property  float $CD1_2
 * @property  float $CD2_1
 * @property  float $CD2_2
 * @property  float $WAVELENG
 * @property  string $SECURITY
 * @property  string $TELESCOP
 * @property  string $INSTRUME
 * @property  string $ORIGIN
 * @property  float $MJD-OBS
 * @property  string $DATE
 * @property float $DRA
 * @property float $DDEC
 *

 */
class MSX extends Eloquent
{
    protected $table = 'MSX';
    protected $primaryKey = 'idMSX';
    public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
        'idMSX' => 'integer',
        'file_name' => 'string',
        'band' => 'string',
        'CTYPE1' => 'string',
        'CTYPE2' => 'string',
        'CTYPE3' => 'string',
        'CRPIX1' => 'float',
        'CRPIX2' => 'float',
        'CRPIX3' => 'float',
        'CRVAL1' => 'float',
        'CRVAL2' => 'float',
        'CRVAL3' => 'float',
        'NAXIS1' => 'integer',
        'NAXIS2' => 'integer',
        'BUNIT' => 'string',
        'CDELT1' => 'float',
        'CDELT2' => 'float',
        'CDELT3' => 'float',
        'CROTA2' => 'float',
        'LONPOLE' => 'float',
        'CD1_1' => 'float',
        'CD1_2' => 'float',
        'CD2_1' => 'float',
        'CD2_2' => 'float',
        'WAVELENG' => 'float',
        'SECURITY' => 'string',
        'TELESCOP' => 'string',
        'INSTRUME' => 'string',
        'ORIGIN' => 'string',
        'MJD-OBS' => 'float',
        'DATE' => 'string',
        'DRA' => 'float',
        'DDEC' => 'float'

    ];

    protected $fillable = [
        'idMSX',
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
        'NAXIS1',
        'NAXIS2',
        'BUNIT',
        'CDELT1',
        'CDELT2',
        'CDELT3',
        'CROTA2',
        'LONPOLE',
        'CD1_1',
        'CD1_2',
        'CD2_1',
        'CD2_2',
        'WAVELENG',
        'SECURITY',
        'TELESCOP',
        'INSTRUME',
        'ORIGIN',
        'MJD-OBS',
        'DATE',
        'DRA',
        'DDEC'
    ];
}
