<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbRadioCont
 * 
 * @property int $idPNMain
 * @property int $idtbRadioCont
 * @property string $band
 *
 * @property PNMain $PNMain
 *

 */
class PNMain_tbRadioCont extends Eloquent
{
	protected $table = 'PNMain_tbRadioCont';
	protected $primaryKey = 'idtbRadioCont';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbRadioCont' => 'int'
	];

	protected $fillable = [
		'idPNMain',
		'band'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}
}
