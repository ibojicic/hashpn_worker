<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbCName
 * 
 * @property int $idPNMain
 * @property int $idtbCName
 * 
 * @property PNMain $PNMain
 * @property tbCName $tbCName
 *

 */
class PNMain_tbCName extends Eloquent
{
	protected $primaryKey = 'idPNMain';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbCName' => 'int'
	];

	protected $fillable = [
		'idtbCName'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tbCName()
	{
		return $this->belongsTo(tbCName::class, 'idtbCName');
	}
}
