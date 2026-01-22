<?php

namespace App\Engine;

use App\Game\City;
use App\Storage\Save;

class GameEngine
{
    public static function bootstrap(string $cityName): City
    {
        $city = new City(name: $cityName);

        Save::write($city);

        return $city;
    }

    public static function tick(): void
    {
        //
    }

    private static function simulate()
    {
        //
    }
}
