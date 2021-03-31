<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 10:47:39 +0000.
 */

namespace HashPN\Models\MainPNData;

use HashPN\Models\MainGPN\PNMain;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class eELCAT
 * 
 * @property int $ideELCAT
 * @property int $idPNMain
 * @property int $no_idPNMain
 * @property string $Name
 * @property string $RegCode
 * @property float $wavelength
 * @property float $rest_wavelength
 * @property string $ionic_id
 * @property string $linename
 * @property int $N_lines
 * @property float $Intensity
 * @property float $tot_Intensity
 * @property string $err_Intensity
 * @property string $int_scale
 * @property string $extinction_applied
 * @property string $elcatCode
 * @property int $oldELCAT
 * @property string $calflag
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\PNMain $PNMain
 *
 
 */
class eELCAT extends Eloquent
{
	protected $table = 'eELCAT';
	protected $primaryKey = 'ideELCAT';
    public $timestamps = true;
    protected $connection = "MainPNData";

    protected $casts = [
		'idPNMain' => 'int',
		'no_idPNMain' => 'int',
		'wavelength' => 'float',
		'rest_wavelength' => 'float',
		'N_lines' => 'int',
		'Intensity' => 'float',
		'tot_Intensity' => 'float',
		'oldELCAT' => 'int'
	];

	protected $fillable = [
		'idPNMain',
		'no_idPNMain',
		'Name',
		'RegCode',
		'wavelength',
		'rest_wavelength',
		'ionic_id',
		'linename',
		'N_lines',
		'Intensity',
		'tot_Intensity',
		'err_Intensity',
		'int_scale',
		'extinction_applied',
		'elcatCode',
		'oldELCAT',
		'calflag',
        'created_at',
        'updated_at'
    ];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'no_idPNMain');
	}
}
