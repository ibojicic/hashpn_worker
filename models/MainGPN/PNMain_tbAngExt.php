<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbAngExt
 * 
 * @property int $idPNMain
 * @property int $idtbAngExt
 * 
 * @property PNMain $PNMain
 * @property tbAngExt $tbAngExt
 *

 */
class PNMain_tbAngExt extends Eloquent
{
	protected $table = 'PNMain_tbAngExt';
	protected $primaryKey = 'idPNMain';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbAngExt' => 'int'
	];

	protected $fillable = [
		'idtbAngExt'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tbAngExt()
	{
		return $this->belongsTo(tbAngExt::class, 'idtbAngExt');
	}
}
