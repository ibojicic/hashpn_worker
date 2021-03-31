<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:21:10 +0000.
 */

namespace HashPN\Models\PNImages;

use Illuminate\Database\Eloquent\Model as Eloquent;
use HashPN\Models\MainGPN\PNMain;

/**
 * Class Ipha
 * 
 * @property int $idiphas
 * @property int $idPNMain
 * @property float $used_RAJ2000
 * @property float $used_DECJ2000
 * @property string $found
 * @property float $distance
 * @property float $exptime
 * @property string $comments
 * @property string $band
 * @property string $field
 * @property string $filename
 * @property int $inuse
 * @property string $attempt
 * @property float $XcutSize
 * @property float $YcutSize
 * @property \Carbon\Carbon $attempt_date
 * @property int $run
 * @property string $run_id
 * @property string $manselected
 * @property string $qcgrade
 *
 * @property PNMain $PNMain
 *

 */
class iphas extends Eloquent
{
	protected $primaryKey = 'idiphas';
	public $timestamps = true;
    protected $connection = "PNImages";


    protected $casts = [
		'idPNMain' => 'int',
		'used_RAJ2000' => 'float',
		'used_DECJ2000' => 'float',
		'distance' => 'float',
		'exptime' => 'float',
		'inuse' => 'int',
		'XcutSize' => 'float',
		'YcutSize' => 'float',
		'run' => 'int'
	];

	protected $dates = [
		'attempt_date'
	];

	protected $fillable = [
		'idPNMain',
		'used_RAJ2000',
		'used_DECJ2000',
		'found',
		'distance',
		'exptime',
		'comments',
		'band',
		'field',
		'filename',
		'inuse',
		'attempt',
		'XcutSize',
		'YcutSize',
		'attempt_date',
		'run',
        'run_id',
		'manselected',
		'qcgrade',
        'inside'
    ];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}
}
