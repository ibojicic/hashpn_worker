<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:21:10 +0000.
 */

namespace HashPN\Models\PNImages;

use Illuminate\Database\Eloquent\Model as Eloquent;
use HashPN\Models\MainGPN\PNMain as PNMain;

/**
 * Class Fitsimage
 * 
 * @property int $idfitsimages
 * @property int $idPNMain
 * @property int $idsourcetable
 * @property string $set
 * @property string $band
 * @property string $filename
 * @property float $XcutSize
 * @property float $YcutSize
 * @property string $run
 * @property string $run_id
 * 
 * @property PNMain $pnmain
 *

 */
class fitsimages extends Eloquent
{
    protected $table = 'fitsimages';
    protected $primaryKey = 'idfitsimages';
	public $timestamps = false;
    protected $connection = "PNImages";


    protected $casts = [
		'idPNMain' => 'int',
		'idsourcetable' => 'int',
		'XcutSize' => 'float',
		'YcutSize' => 'float'
	];

	protected $fillable = [
		'idPNMain',
		'idsourcetable',
		'set',
		'band',
		'filename',
		'XcutSize',
		'YcutSize',
		'run',
        'run_id'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}
}
