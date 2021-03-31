<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class DataDictionary
 * 
 * @property int $iddataDictionary
 * @property string $vizierCatalogue
 * @property string $vizierTable
 * @property string $sourcePaper
 * @property string $columnName
 * @property string $columnType
 * @property string $fill_value
 * @property string $extraColumn
 * @property string $maptoDatabase
 * @property string $maptoTable
 * @property string $maptoColumn
 * @property string $maptoType
 * @property string $maptoBand
 * @property string $maptoConvert
 * @property string $maptoConvertType
 * @property int $recordGroup
 * @property string $comment
 *

 */
class dataDictionary extends Eloquent
{
	protected $table = 'dataDictionary';
	protected $primaryKey = 'iddataDictionary';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'recordGroup' => 'int'
	];

	protected $fillable = [
		'vizierCatalogue',
		'vizierTable',
		'sourcePaper',
		'columnName',
		'columnType',
		'fill_value',
		'extraColumn',
		'maptoDatabase',
		'maptoTable',
		'maptoColumn',
		'maptoType',
		'maptoBand',
		'maptoConvert',
		'maptoConvertType',
		'recordGroup',
		'comment'
	];
}
