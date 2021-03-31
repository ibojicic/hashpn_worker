<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:21:10 +0000.
 */

namespace HashPN\Models\PNImages;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Atlas
 * 
 * @property int $idatlas
 * @property int $idPNMain
 * @property float $used_RAJ2000
 * @property float $used_DECJ2000
 * @property string $found
 * @property string $comments
 * @property string $band
 * @property string $field
 * @property string $filename
 * @property int $inuse
 * @property string $attempt
 * @property float $XcutSize
 * @property float $YcutSize
 * @property \Carbon\Carbon $attempt_date
 * @property float $distance
 * @property float $exptime
 * @property int $run
 * @property string $run_id
 * @property string $manselected
 * @property string $tmpflag
 *

 */
class atlas extends Eloquent
{
	protected $primaryKey = 'idatlas';
	public $timestamps = true;
    protected $connection = "PNImages";


    protected $casts = [
		'idPNMain' => 'int',
		'used_RAJ2000' => 'float',
		'used_DECJ2000' => 'float',
		'inuse' => 'int',
		'XcutSize' => 'float',
		'YcutSize' => 'float',
		'distance' => 'float',
		'exptime' => 'float',
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
		'comments',
		'band',
		'field',
		'filename',
		'inuse',
		'attempt',
		'XcutSize',
		'YcutSize',
		'attempt_date',
		'distance',
		'exptime',
		'run',
        'run_id',
		'manselected',
		'tmpflag',
        'inside'
	];
}
