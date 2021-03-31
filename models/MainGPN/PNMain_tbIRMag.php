<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainTbIRMag
 * 
 * @property int $idPNMain
 * @property int $idtbIRMag
 * @property string $band
 *
 * @property PNMain $PNMain
 * @property tbIRMag $tbIRMag
 *
 */
class PNMain_tbIRMag extends Eloquent
{
	protected $table = 'PNMain_tbIRMag';
	protected $primaryKey = 'idtbIRMag';
	public $incrementing = false;
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'idtbIRMag' => 'int'
	];

	protected $fillable = [
		'idPNMain',
		'band'
	];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function tbIRMag()
	{
		return $this->belongsTo(tbIRMag::class, 'idtbIRMag');
	}
}
