<?php

namespace App\Handler\Command;

use App\Message\Command\CreateWeather;

class CreateWeatherHandler
{
    public function __invoke(CreateWeather $query)
    {
        dd($query);
    }
}