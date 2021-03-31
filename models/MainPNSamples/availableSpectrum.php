<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:09:22 +0000.
 */

namespace HashPN\Models\MainPNSamples;

use HashPN\Models\MainGPN\PNMain;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class availableSpectrum
 * 
 * @property int $idavailableSpectrum
 * @property int $idPNMain
 * @property string $spectrum
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\PNMain $PNMain
 *
 
 */
class availableSpectrum extends Eloquent
{

    protected $table = 'availableSpectrum';
    protected $primaryKey = 'idavailableSpectrum';
    public $timestamps = true;
    protected $connection = "MainPNSamples";

    protected $casts = [
        'idPNMain' => 'int'
    ];

	protected $fillable = [
		'idPNMain',
		'spectrum',
		'created_at',
        'updated_at'
    ];

    public function PNMain()
    {
        return $this->belongsTo(PNMain::class, 'idPNMain');
    }
}
