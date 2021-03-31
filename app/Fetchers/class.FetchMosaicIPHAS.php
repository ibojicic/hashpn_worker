<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;


class fetchMosaicIPHAS extends Fetcher implements FetchersInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchit()
    {
        $inside = $this->survey->getResultsModel();
        dd($inside);
        return False;
    }


}