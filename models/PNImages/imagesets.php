<?php
/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:21:10 +0000.
 */
namespace HashPN\Models\PNImages;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Imageset
 *
 * @property int $idimagesets
 * @property string $set
 * @property string $checked
 * @property string $images
 * @property string $folder
 * @property string $fetchmethod
 * @property string $montageName
 * @property string $fetcher
 * @property string $siapURL
 * @property string $siapFields
 * @property string $siap_extra
 * @property string $correctXML
 * @property string $multiple
 * @property string $origin
 * @property float $maxDiam
 * @property string $function
 * @property string $rotate
 * @property string $link
 * @property string $table
 * @property string $model
 * @property string $imfolder
 * @property string $ongoing
 * @property string $hdrfields
 * @property string $bands
 * @property string $bandsMap
 * @property string $bandfield
 * @property string $exptimefield
 * @property string $source_folder
 * @property float $search_radii
 * @property float $minval
 * @property float $maxval
 * @property string $imagestable
 * @property string $resultsmodel
 * @property string $Xcoord
 * @property string $Ycoord
 * @property string $Xsource
 * @property string $Ysource
 * @property string $Xpix
 * @property string $Ypix
 * @property string $Xincrease
 * @property string $Yincrease
 * @property string $epoch
 * @property float $minimDiam
 * @property float $maximDiam
 * @property float $pixscale
 * @property string $drawbeam
 * @property string $cutter
 * @property bool $overlap
 * @property string $multipleExt
 * @property int $fitsExt
 * @property string $findby
 * @property string $findmet
 * @property string $quotpairs
 * @property string $quotpair
 * @property string $quotbands
 * @property string $fitsfunc
 * @property string $fetchfitsfunc
 * @property string $compress
 * @property string $decompress
 * @property string $extrafields
 * @property string $use
 *

 */
class Imagesets extends Eloquent
{
    public $timestamps = false;
    protected $connection = "PNImages";
    protected $primaryKey = 'idimagesets';
    protected $casts = [
        'set'   => 'string',
        'maxDiam' => 'float',
        'search_radii' => 'float',
        'minval' => 'float',
        'maxval' => 'float',
        'minimDiam' => 'float',
        'maximDiam' => 'float',
        'pixscale' => 'float',
        'overlap' => 'bool',
        'fitsExt' => 'int'
    ];


    protected $fillable = [
        'set',
        'checked',
        'images',
        'folder',
        'fetchmethod',
        'montageName',
        'fetcher',
        'siapURL',
        'siapFields',
        'siap_extra',
        'correctXML',
        'multiple',
        'origin',
        'maxDiam',
        'function',
        'rotate',
        'link',
        'table',
        'model',
        'imfolder',
        'ongoing',
        'hdrfields',
        'bands',
        'bandsMap',
        'bandfield',
        'exptimefield',
        'source_folder',
        'search_radii',
        'minval',
        'maxval',
        'imagestable',
        'resultsmodel',
        'Xcoord',
        'Ycoord',
        'Xsource',
        'Ysource',
        'Xpix',
        'Ypix',
        'Xincrease',
        'Yincrease',
        'epoch',
        'minimDiam',
        'maximDiam',
        'pixscale',
        'drawbeam',
        'cutter',
        'overlap',
        'multipleExt',
        'fitsExt',
        'findby',
        'findmet',
        'quotpairs',
        'quotpair',
        'quotbands',
        'fitsfunc',
        'fetchfitsfunc',
        'compress',
        'decompress',
        'extrafields',
        'use'
    ];
}

