<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbPNMorph
 * 
 * @property int $idPNMain
 * @property int $idtbPNMorph
 *
 * @property PNMain $PNMain
 * @property tbPNMorph $tbPNMorph
 *
 */
class PNMain_tbPNMorph extends Eloquent
{
	protected $table = 'PNMain_tbPNMorph';
	protected $primaryKey = 'idPNMain';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbPNMorph' => 'int'
	];

	protected $fillable = [
		'idtbPNMorph'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tbPNMorph()
	{
		return $this->belongsTo(tbPNMorph::class, 'idtbPNMorph');
	}
}
