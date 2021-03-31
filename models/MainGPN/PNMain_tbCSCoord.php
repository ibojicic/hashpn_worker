<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbCSCoord
 * 
 * @property int $idPNMain
 * @property int $idtbCSCoords
 *
 * @property PNMain $PNMain
 * @property tbCSCoord $tbCSCoord
 *
 */
class PNMain_tbCSCoord extends Eloquent
{
	protected $primaryKey = 'idPNMain';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbCSCoords' => 'int'
	];

	protected $fillable = [
		'idtbCSCoords'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tbCSCoord()
	{
		return $this->belongsTo(tbCSCoord::class, 'idtbCSCoords');
	}
}
