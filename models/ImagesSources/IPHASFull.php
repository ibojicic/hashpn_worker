<?php
/**
 * Created by Reliese Model.
 * Date: Thu, 29 Dec 2016 12:08:07 +0000.
 */

namespace HashPN\Models\ImagesSources;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class IPHASFull
 * 
 * @property int $id
 * @property int $run
 * @property int $ccd
 * @property string $url
 * @property float $ra
 * @property float $dec
 * @property string $band
 * @property string $utstart
 * @property string $fieldid
 * @property string $in_dr2
 * @property string $qcgrade
 * @property string $qcproblems
 * @property float $exptime
 * @property float $seeing
 * @property float $elliptic
 * @property float $skylevel
 * @property float $skynoise
 * @property float $depth
 * @property float $photzp
 * @property string $confmap
 * @property float $ra_min
 * @property float $ra_max
 * @property float $dec_min
 * @property float $dec_max
 * @property string $file_name
 * @property string $downloaded
 * @property string $run_id
 *

 */
class IPHASFull extends Eloquent
{
	protected $table = 'IPHASFull';
	public $timestamps = false;
    protected $connection = "ImagesSources";


    protected $casts = [
		'run' => 'int',
		'ccd' => 'int',
		'ra' => 'float',
		'dec' => 'float',
		'exptime' => 'float',
		'seeing' => 'float',
		'elliptic' => 'float',
		'skylevel' => 'float',
		'skynoise' => 'float',
		'depth' => 'float',
		'photzp' => 'float',
		'ra_min' => 'float',
		'ra_max' => 'float',
		'dec_min' => 'float',
		'dec_max' => 'float'
	];

	protected $fillable = [
		'run',
		'ccd',
		'url',
		'ra',
		'dec',
		'band',
		'utstart',
		'fieldid',
		'in_dr2',
		'qcgrade',
		'qcproblems',
		'exptime',
		'seeing',
		'elliptic',
		'skylevel',
		'skynoise',
		'depth',
		'photzp',
		'confmap',
		'ra_min',
		'ra_max',
		'dec_min',
		'dec_max',
		'file_name',
		'downloaded',
        'run_id',
	];
}
