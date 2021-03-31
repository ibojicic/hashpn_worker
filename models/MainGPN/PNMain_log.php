<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PNMainLog
 * 
 * @property int $idlog
 * @property int $idPNMain
 * @property string $PNG
 * @property string $refPNG
 * @property string $RAJ2000
 * @property string $DECJ2000
 * @property float $DRAJ2000
 * @property float $DDECJ2000
 * @property float $Glon
 * @property float $Glat
 * @property string $refCoord
 * @property string $Catalogue
 * @property string $refCatalogue
 * @property string $userRecord
 * @property string $domain
 * @property string $refDomain
 * @property string $PNstat
 * @property string $refPNstat
 * @property string $action
 * @property \Carbon\Carbon $date
 *

 */
class PNMain_log extends Eloquent
{
	protected $table = 'PNMain_log';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'idPNMain' => 'int',
		'DRAJ2000' => 'float',
		'DDECJ2000' => 'float',
		'Glon' => 'float',
		'Glat' => 'float'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'PNG',
		'refPNG',
		'RAJ2000',
		'DECJ2000',
		'DRAJ2000',
		'DDECJ2000',
		'Glon',
		'Glat',
		'refCoord',
		'Catalogue',
		'refCatalogue',
		'userRecord',
		'domain',
		'refDomain',
		'PNstat',
		'refPNstat',
		'action',
		'date'
	];
}
