<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTblogFOIII
 * 
 * @property int $idPNMain
 * @property int $idtblogFOIII
 *
 * @property PNMain $PNMain
 * @property tblogFOIII $tblogFOIII
 *
 */
class PNMain_tblogFOIII extends Eloquent
{
	protected $table = 'PNMain_tblogFOIII';
	protected $primaryKey = 'idPNMain';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idtblogFOIII' => 'int'
	];

	protected $fillable = [
		'idtblogFOIII'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tblogFOIII()
	{
		return $this->belongsTo(tblogFOIII::class, 'idtblogFOIII');
	}
}
