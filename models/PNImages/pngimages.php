<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:21:10 +0000.
 */

namespace HashPN\Models\PNImages;

use HashPN\Models\MainGPN\PNMain;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Pngimage
 * 
 * @property int $idpngimages
 * @property int $idPNMain
 * @property string $OUT_DIR
 * @property string $in
 * @property string $OutImage
 * @property float $min_r
 * @property float $max_r
 * @property float $min_v
 * @property float $max_v
 * @property string $R
 * @property string $G
 * @property string $B
 * @property string $rgb_cube
 * @property float $minR_r
 * @property float $minG_r
 * @property float $minB_r
 * @property float $maxR_r
 * @property float $maxG_r
 * @property float $maxB_r
 * @property float $minR_v
 * @property float $minG_v
 * @property float $minB_v
 * @property float $maxR_v
 * @property float $maxG_v
 * @property float $maxB_v
 * @property string $imlev
 * @property float $DRAJ2000
 * @property float $DDECJ2000
 * @property float $MajDiam
 * @property float $MinDiam
 * @property float $PA
 * @property float $ImageSize
 * @property float $BoxSize
 * @property float $statbox
 * @property string $Set
 * @property string $DrawBeam
 * @property \Carbon\Carbon $Date
 * @property string $run
 * @property string $run_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at

 * @property string $flag
 *
 * @property PNMain $PNMain
 *

 */
class pngimages extends Eloquent
{
    protected $table = 'pngimages';
    protected $primaryKey = 'idpngimages';
	public $timestamps = true;
    protected $connection = "PNImages";


    protected $casts = [
		'idPNMain' => 'int',
		'min_r' => 'float',
		'max_r' => 'float',
		'min_v' => 'float',
		'max_v' => 'float',
		'minR_r' => 'float',
		'minG_r' => 'float',
		'minB_r' => 'float',
		'maxR_r' => 'float',
		'maxG_r' => 'float',
		'maxB_r' => 'float',
		'minR_v' => 'float',
		'minG_v' => 'float',
		'minB_v' => 'float',
		'maxR_v' => 'float',
		'maxG_v' => 'float',
		'maxB_v' => 'float',
		'DRAJ2000' => 'float',
		'DDECJ2000' => 'float',
		'MajDiam' => 'float',
		'MinDiam' => 'float',
		'PA' => 'float',
		'ImageSize' => 'float',
		'BoxSize' => 'float',
		'statbox' => 'float'
	];

	protected $dates = [
		'Date'
	];

	protected $fillable = [
		'idPNMain',
		'OUT_DIR',
		'in',
		'OutImage',
		'min_r',
		'max_r',
		'min_v',
		'max_v',
		'R',
		'G',
		'B',
		'rgb_cube',
		'minR_r',
		'minG_r',
		'minB_r',
		'maxR_r',
		'maxG_r',
		'maxB_r',
		'minR_v',
		'minG_v',
		'minB_v',
		'maxR_v',
		'maxG_v',
		'maxB_v',
		'imlev',
		'DRAJ2000',
		'DDECJ2000',
		'MajDiam',
		'MinDiam',
		'PA',
		'ImageSize',
		'BoxSize',
		'statbox',
		'Set',
		'DrawBeam',
		'Date',
		'run',
        'run_id',
        'created_at',
        'udated_at',
		'flag'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}
}
