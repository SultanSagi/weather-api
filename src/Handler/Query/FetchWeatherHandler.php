<?php

namespace App\Handler\Query;

use App\Message\Query\FetchWeatherQuery;

class FetchWeatherHandler
{
    public function __invoke(FetchWeatherQuery $query)
    {
        dd($query);
    }
}