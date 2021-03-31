<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Jan 2017 05:49:13 +0000.
 */
namespace HashPN\Models\MainGPN;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class TablesInfo
 * 
 * @property int $idInfo
 * @property string $varName
 * @property int $varOrder
 * @property string $varTable
 * @property string $tableLongName
 * @property string $varColumn
 * @property string $varType
 * @property string $varUnits
 * @property int $varGroup
 * @property bool $varSearch
 * @property string $varVar
 * @property int $varSee
 * @property int $varMain
 * @property string $comment
 * @property int $showInfo
 * @property string $editable
 * @property string $relatedTo
 * @property string $relation
 * @property string $showInTable
 * @property string $bandMapped
 * @property string $band
 * @property string $bandtype
 * @property string $public
 *

 */
class tablesInfo extends Eloquent
{
	protected $table = 'tablesInfo';
	protected $primaryKey = 'idInfo';
	public $timestamps = false;
    protected $connection = "MainGPN";


    protected $casts = [
		'varOrder' => 'int',
		'varGroup' => 'int',
		'varSearch' => 'bool',
		'varSee' => 'int',
		'varMain' => 'int',
		'showInfo' => 'int'
	];

	protected $fillable = [
		'varName',
		'varOrder',
		'varTable',
		'tableLongName',
		'varColumn',
		'varType',
		'varUnits',
		'varGroup',
		'varSearch',
		'varVar',
		'varSee',
		'varMain',
		'comment',
		'showInfo',
		'editable',
		'relatedTo',
		'relation',
		'showInTable',
		'bandMapped',
		'band',
		'bandtype',
		'public'
	];
}
