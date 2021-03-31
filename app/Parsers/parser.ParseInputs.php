<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 28/2/2017
 * Time: 8:33 AM
 */

namespace HashPN\App\Parsers;


use HashPN\Models\MainGPN\PNMain;
use HashPN\Models\PNImages\Imagesets;
use HashPN\Models\PNImages\pngimagesinfo;
use HashPN\Models\PNSpectra_Sources\spectraInfo;
use MyPHP\MyArrays;

class ParseInputs
{

    /**
     * Parse the inputs for fetch/brew console scripts
     * @param $input string set1,set2,setx,sety,....
     * @param $script string script name fetch/brew
     * @return array|boolean ['found' => ['set1','set2',....], 'notfound' => ['setx','sety',....]], False on error
     */
    public static function parseSets($input,$script)
    {
        $full = self::getFullSets($script);
        if (!$full) {
            return False;
        }
        $exploded = array_unique(array_map('trim', explode(",", $input)));
        if ($input == 'all') {
            $result = ['found' => $full, 'notfound' => []];
        } else {
            $result_vals = array_intersect($exploded, $full);
            $result_keys = array_intersect_key($full,array_flip($exploded));
            $result['found'] = array_unique(array_merge($result_vals,$result_keys));
            $result['notfound']= array_diff($exploded,array_merge($result_vals,array_keys($result_keys)));
        }
        return $result;
    }

    /**
     * Parse the input for idPNMain
     * @param $input string id1,id2,....
     * @param bool|string $where MySQL WHERE (only applies to PNMain table)
     * @return array|bool of IDs
     */
    public static function parseIDs($input, $where = False)
    {
        $exploded = array_unique(array_map('trim', explode(",", $input)));

        if ($where) {
            $model = PNMain::whereRaw($where);
        } else {
            $model = new PNMain();
        }

        if ($input != 'all') {
            $model = $model
                ->whereIn('idPNMain',$exploded);
        }

        if (!$model || $model == null) {
            return False;
        }

        $result = $model->pluck('idPNMain')
            ->toArray();
        return $result;
    }

    /**
     * @param $script string name of the script fetch/brew/spetch
     * @return bool|array ['id1' => 'name1', .....] of False on unsuccessful
     */
    public static function getFullSets($script)
    {
        switch ($script) {
            case 'fetch':
                $base = Imagesets::where('use','y')
                    ->get(['idimagesets','set'])
                    ->toArray();
                return MyArrays::simplfyArray($base,'idimagesets','set');
                break;
            case 'brew':
                $base = pngimagesinfo::where('use','y')
                    ->get(['idpngimagesinfo','name'])
                    ->toArray();
                return MyArrays::simplfyArray($base,'idpngimagesinfo','name');
                break;
            case 'spetch':
                $base = spectraInfo::get(['idspectraInfo','name'])
                    ->toArray();
                return MyArrays::simplfyArray($base,'idspectraInfo','name');
                break;
        }
        return False;
    }





}