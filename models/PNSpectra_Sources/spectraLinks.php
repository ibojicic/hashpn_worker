<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:09:22 +0000.
 */

namespace HashPN\Models\PNSpectra_Sources;

use HashPN\Models\MainGPN\PNMain;
use HashPN\Models\MainGPN\ReferenceIDs;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class spectraLinks
 * 
 * @property int $idspectraLinks
 * @property int $idPNMain
 * @property string $reference
 * @property string $user
 * @property string $comments
 * @property \Carbon\Carbon $date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property PNMain $PNMain
 * @property ReferenceIDs $ReferenceIDs
 *
 
 */
class spectraLinks extends Eloquent
{
    protected $table = 'spectraLinks';
    protected $primaryKey = 'idspectraLinks';
    public $timestamps = true;
    protected $connection = "PNSpectra_Sources";

    protected $casts = [
		'idPNMain' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'idPNMain',
		'reference',
		'user',
		'comments',
		'date',
        'created_at',
        'updated_at'
    ];

	public function PNMain()
	{
		return $this->belongsTo(PNMain::class, 'idPNMain');
	}

	public function ReferenceIDs()
	{
		return $this->belongsTo(ReferenceIDs::class, 'reference', 'Identifier');
	}
}
