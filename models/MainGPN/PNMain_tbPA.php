<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbPA
 * 
 * @property int $idPNMain
 * @property int $idtbPA
 *
 * @property PNMain $PNMain
 *

 */
class PNMain_tbPA extends Eloquent
{
	protected $table = 'PNMain_tbPA';
	protected $primaryKey = 'idPNMain';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbPA' => 'int'
	];

	protected $fillable = [
		'idtbPA'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}
}
