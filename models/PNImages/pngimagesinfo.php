<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:21:10 +0000.
 */
namespace HashPN\Models\PNImages;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Pngimagesinfo
 * 
 * @property int $idpngImagesInfo
 * @property string $type
 * @property string $name
 * @property float $psf
 * @property string $checked
 * @property string $skip
 * @property string $wavelength
 * @property int $defaultwall
 * @property int $imageorder
 * @property string $group
 * @property int $groupid
 * @property int $defaultgrp
 * @property string $ingroup
 * @property int $prioringroup
 * @property string $inImage
 * @property string $in_folder
 * @property string $in_srv
 * @property string $in_band
 * @property string $R
 * @property string $G
 * @property string $B
 * @property string $R_folder
 * @property string $R_srv
 * @property string $R_band
 * @property string $G_folder
 * @property string $G_srv
 * @property string $G_band
 * @property string $B_folder
 * @property string $B_srv
 * @property string $B_band
 * @property string $name_out
 * @property string $outFolder
 * @property string $natcoords
 * @property int $minimDiam
 * @property float $resolution
 * @property string $box
 * @property string $printname
 * @property string $centroid_col
 * @property string $maxext_col
 * @property string $CS_pos_col
 * @property float $min_imLevel
 * @property float $imLevel
 * @property float $min_r_imLevel
 * @property float $r_imLevel
 * @property float $min_g_imLevel
 * @property float $g_imLevel
 * @property float $min_b_imLevel
 * @property float $b_imLevel
 * @property string $imlev
 * @property int $defaultsee
 * @property string $drawbeam
 * @property int $showorder
 * @property int $sthumb_pref
 * @property string $tempimage
 * @property string $showingallery
 * @property string $multiple
 * @property string $difflevel
 *

 */
class pngimagesinfo extends Eloquent
{
	protected $table = 'pngimagesinfo';
	protected $primaryKey = 'idpngImagesInfo';
	public $timestamps = false;
    protected $connection = "PNImages";


    protected $casts = [
		'psf' => 'float',
		'defaultwall' => 'int',
		'imageorder' => 'int',
		'groupid' => 'int',
		'defaultgrp' => 'int',
		'prioringroup' => 'int',
		'minimDiam' => 'int',
		'resolution' => 'float',
		'min_imLevel' => 'float',
		'imLevel' => 'float',
		'min_r_imLevel' => 'float',
		'r_imLevel' => 'float',
		'min_g_imLevel' => 'float',
		'g_imLevel' => 'float',
		'min_b_imLevel' => 'float',
		'b_imLevel' => 'float',
		'defaultsee' => 'int',
		'showorder' => 'int',
		'sthumb_pref' => 'int'
	];

	protected $fillable = [
		'type',
		'name',
		'psf',
		'checked',
		'skip',
		'wavelength',
		'defaultwall',
		'imageorder',
		'group',
		'groupid',
		'defaultgrp',
		'ingroup',
		'prioringroup',
		'inImage',
		'in_folder',
		'in_srv',
		'in_band',
		'R',
		'G',
		'B',
		'R_folder',
		'R_srv',
		'R_band',
		'G_folder',
		'G_srv',
		'G_band',
		'B_folder',
		'B_srv',
		'B_band',
		'name_out',
		'outFolder',
		'natcoords',
		'minimDiam',
		'resolution',
		'box',
		'printname',
		'centroid_col',
		'maxext_col',
		'CS_pos_col',
		'min_imLevel',
		'imLevel',
		'min_r_imLevel',
		'r_imLevel',
		'min_g_imLevel',
		'g_imLevel',
		'min_b_imLevel',
		'b_imLevel',
		'imlev',
		'defaultsee',
		'drawbeam',
		'showorder',
		'sthumb_pref',
		'tempimage',
		'showingallery',
		'multiple',
		'difflevel'
	];
}
