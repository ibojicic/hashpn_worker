<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbHrvel
 * 
 * @property int $idPNMain
 * @property int $idtbHrvel
 *
 * @property PNMain $PNMain
 * @property tbHrvel $tbHrvel
 *
 */
class PNMain_tbHrvel extends Eloquent
{
	protected $table = 'PNMain_tbHrvel';
	protected $primaryKey = 'idPNMain';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbHrvel' => 'int'
	];

	protected $fillable = [
		'idtbHrvel'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tbHrvel()
	{
		return $this->belongsTo(tbHrvel::class, 'idtbHrvel');
	}
}
