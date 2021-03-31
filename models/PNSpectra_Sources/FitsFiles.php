<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:09:22 +0000.
 */

namespace HashPN\Models\PNSpectra_Sources;

use HashPN\Models\MainGPN\PNMain;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class FitsFiles
 * 
 * @property int $idFitsFiles
 * @property string $setname
 * @property string $fileName
 * @property string $outName
 * @property string $reference
 * @property string $parsedIn
 * @property int $idPNMain
 * @property string $dateObs
 * @property string $observer
 * @property string $object
 * @property string $instrument
 * @property string $filter
 * @property string $telescope
 * @property string $instrflag
 * @property string $RAJ2000
 * @property string $DECJ2000
 * @property float $DRAJ2000
 * @property float $DDECJ2000
 * @property \Carbon\Carbon $date
 * @property string $convToText
 * @property string $checked
 * @property int $inUse
 * @property string $parserflag
 * @property float $xfactor
 * @property string $tempname
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\PNMain $PNMain
 * @property \App\Models\SpectraInfo $spectraInfo
 *

 */
class FitsFiles extends Eloquent
{
    protected $table = 'FitsFiles';
    protected $primaryKey = 'idFitsFiles';
    public $timestamps = true;
    protected $connection = "PNSpectra_Sources";


    protected $casts = [
		'idPNMain' => 'int',
		'DRAJ2000' => 'float',
		'DDECJ2000' => 'float',
		'inUse' => 'int',
		'xfactor' => 'float'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'setname',
		'fileName',
		'outName',
		'reference',
		'parsedIn',
		'idPNMain',
		'dateObs',
		'observer',
		'object',
		'instrument',
		'filter',
		'telescope',
		'instrflag',
		'RAJ2000',
		'DECJ2000',
		'DRAJ2000',
		'DDECJ2000',
		'date',
		'convToText',
		'checked',
		'inUse',
		'parserflag',
		'xfactor',
		'tempname',
        'created_at',
        'updated_at'
    ];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function spectraInfo()
	{
		return $this->belongsTo(spectraInfo::class, 'setname', 'name');
	}
}
