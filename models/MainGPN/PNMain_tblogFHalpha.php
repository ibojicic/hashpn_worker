<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTblogFHalpha
 * 
 * @property int $idPNMain
 * @property int $idtblogFHalpha
 *
 * @property PNMain $PNMain
 * @property tblogFHalpha $tblogFHalpha
 *
 */
class PNMain_tblogFHalpha extends Eloquent
{
	protected $table = 'PNMain_tblogFHalpha';
	protected $primaryKey = 'idPNMain';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idtblogFHalpha' => 'int'
	];

	protected $fillable = [
		'idtblogFHalpha'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tblogFHalpha()
	{
		return $this->belongsTo(tblogFHalpha::class, 'idtblogFHalpha');
	}
}
