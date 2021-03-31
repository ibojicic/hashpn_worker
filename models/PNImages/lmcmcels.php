<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:21:10 +0000.
 */

namespace HashPN\Models\PNImages;

use HashPN\Models\MainGPN\PNMain;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class LmcMcel
 * 
 * @property int $idlmc_mcels
 * @property int $idPNMain
 * @property float $used_RAJ2000
 * @property float $used_DECJ2000
 * @property string $found
 * @property string $comments
 * @property string $band
 * @property string $field
 * @property string $filename
 * @property int $inuse
 * @property float $distance
 * @property float $exptime
 * @property string $attempt
 * @property float $XcutSize
 * @property float $YcutSize
 * @property int $run
 * @property string $run_id
 * @property \Carbon\Carbon $attempt_date
 * @property string $tmpflag
 *
 * @property PNMain $PNMain
 *

 */
class lmc_mcels extends Eloquent
{
	protected $primaryKey = 'idlmc_mcels';
	public $timestamps = true;
    protected $connection = "PNImages";


    protected $casts = [
		'idPNMain' => 'int',
		'used_RAJ2000' => 'float',
		'used_DECJ2000' => 'float',
		'inuse' => 'int',
		'distance' => 'float',
		'exptime' => 'float',
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
		'comments',
		'band',
		'field',
		'filename',
		'inuse',
		'distance',
		'exptime',
		'attempt',
		'XcutSize',
		'YcutSize',
		'run',
        'run_id',
		'attempt_date',
		'tmpflag',
        'inside'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}
}
