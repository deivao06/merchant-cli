<?php

namespace App\Engine;

use App\Game\City;

class GameEngine
{
    public static function bootstrap(string $cityName): City
    {
        return new City(name: $cityName);
    }

    public static function tick()
    {

    }

    private static function simulate()
    {

    }
}
