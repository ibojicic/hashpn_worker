<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 12/1/2017
 * Time: 8:23 AM
 */
namespace HashPN\App\Fetchers;


class fetchDummy extends Fetcher implements FetchersInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchit()
    {
        return False;
    }


}