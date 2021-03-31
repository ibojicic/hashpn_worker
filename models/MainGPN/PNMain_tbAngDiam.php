<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbAngDiam
 * 
 * @property int $idPNMain
 * @property int $idtbAngDiam
 * 
 * @property PNMain $PNMain
 * @property tbAngDiam $tb_ang_diam
 *

 */
class PNMain_tbAngDiam extends Eloquent
{
	protected $table = 'PNMain_tbAngDiam';
	protected $primaryKey = 'idPNMain';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbAngDiam' => 'int'
	];

	protected $fillable = [
		'idtbAngDiam'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tbAngDiam()
	{
		return $this->belongsTo(tbAngDiam::class, 'idtbAngDiam');
	}
}
