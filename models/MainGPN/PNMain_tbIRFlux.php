<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbIRFlux
 * 
 * @property int $idPNMain
 * @property int $idtbIRFlux
 * @property string $band
 *
 * @property PNMain $PNMain
 * @property tbIRFlux $tbIRFlux
 *
 */
class PNMain_tbIRFlux extends Eloquent
{
	protected $table = 'PNMain_tbIRFlux';
	protected $primaryKey = 'idtbIRFlux';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbIRFlux' => 'int'
	];

	protected $fillable = [
		'idPNMain',
		'band'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tbIRFlux()
	{
		return $this->belongsTo(tbIRFlux::class, 'idtbIRFlux');
	}
}
