<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class VPHASplus
 * 
 * @property int $idVPHASplus
 * @property string $file_name
 * @property string $original_file_name
 * @property string $band
 * @property string $CTYPE1
 * @property string $CTYPE2
 * @property float $CRPIX1
 * @property float $CRPIX2
 * @property float $CRVAL1
 * @property float $CRVAL2
 * @property int $NAXIS1
 * @property int $NAXIS2
 * @property float $CD1_1
 * @property float $CD1_2
 * @property float $CD2_1
 * @property float $CD2_2
 * @property string $DATE
 * @property float $SEEING
 * @property float $ELLIPTIC
 * @property float $STDCRMS
 * @property string $BUNIT
 * @property string $PHOTSYS
 * @property float $PSF_FWHM
 * @property float $ABMAGLIM
 * @property float $ABMAGSAT
 * @property float $PHOTZP
 * @property float $PHOTZPER
 * @property float $EXPTIME
 * @property string $CHECKSUM
 * @property string $TELESCOP
 * @property string $INSTRUME
 * @property string $OBJECT
 * @property string $RA
 * @property string $DEC
 * @property string $EQUINOX
 * @property string $RADECSYS
 * @property string $MJD_OBS
 * @property string $DATE_OBS
 * @property string $UTC
 * @property string $LST
 * @property string $PI-COI
 * @property string $OBSERVER
 * @property string $ORIGFILE
 * @property string $ARCFILE
 * @property string $OBSTATUS
 * @property string $ESOGRADE
 * @property string $FILTER
 * @property string $PROG_ID
 * @property string $OBSTECH
 * @property string $TL_RA
 * @property string $TL_DEC
 * @property string $TL_OFFAN
 * @property string $TL_ID
 * @property string $OBID1
 * @property string $MJD_END
 * @property string $PROCSOFT
 * @property string $PRODCATG
 * @property string $IMATYPE
 * @property string $FLUXCAL
 * @property string $EPS_REG
 * @property string $ASSON1
 * @property string $ASSOC1
 * @property string $PROV1
 * @property string $NCOMBINE
 * @property float $DRA
 * @property float $DDEC
 * @property string $flag
 *

 */
class VPHASplus extends Eloquent
{
	protected $table = 'VPHASplus';
	protected $primaryKey = 'idVPHASplus';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'CRPIX1' => 'float',
		'CRPIX2' => 'float',
		'CRVAL1' => 'float',
		'CRVAL2' => 'float',
		'NAXIS1' => 'int',
		'NAXIS2' => 'int',
		'CD1_1' => 'float',
		'CD1_2' => 'float',
		'CD2_1' => 'float',
		'CD2_2' => 'float',
		'SEEING' => 'float',
		'ELLIPTIC' => 'float',
		'STDCRMS' => 'float',
		'PSF_FWHM' => 'float',
		'ABMAGLIM' => 'float',
		'ABMAGSAT' => 'float',
		'PHOTZP' => 'float',
		'PHOTZPER' => 'float',
		'EXPTIME' => 'float',
		'DRA' => 'float',
		'DDEC' => 'float'
	];

	protected $fillable = [
		'file_name',
		'original_file_name',
		'band',
		'CTYPE1',
		'CTYPE2',
		'CRPIX1',
		'CRPIX2',
		'CRVAL1',
		'CRVAL2',
		'NAXIS1',
		'NAXIS2',
		'CD1_1',
		'CD1_2',
		'CD2_1',
		'CD2_2',
		'DATE',
		'SEEING',
		'ELLIPTIC',
		'STDCRMS',
		'BUNIT',
		'PHOTSYS',
		'PSF_FWHM',
		'ABMAGLIM',
		'ABMAGSAT',
		'PHOTZP',
		'PHOTZPER',
		'EXPTIME',
		'CHECKSUM',
		'TELESCOP',
		'INSTRUME',
		'OBJECT',
		'RA',
		'DEC',
		'EQUINOX',
		'RADECSYS',
		'MJD-OBS',
		'DATE-OBS',
		'UTC',
		'LST',
		'PI-COI',
		'OBSERVER',
		'ORIGFILE',
		'ARCFILE',
		'OBSTATUS',
		'ESOGRADE',
		'FILTER',
		'PROG_ID',
		'OBSTECH',
		'TL_RA',
		'TL_DEC',
		'TL_OFFAN',
		'TL_ID',
		'OBID1',
		'MJD-END',
		'PROCSOFT',
		'PRODCATG',
		'IMATYPE',
		'FLUXCAL',
		'EPS_REG',
		'ASSON1',
		'ASSOC1',
		'PROV1',
		'NCOMBINE',
		'DRA',
		'DDEC',
		'flag'
	];
}
