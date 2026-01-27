<?php

namespace App\Engine;

use App\Game\Building;
use App\Game\City;
use App\Storage\Save;
use Illuminate\Support\Carbon;

use function Illuminate\Support\now;

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
        $simulate = self::simulate(Save::load(), Save::last_tick());

        Save::write($simulate);
    }

    private static function simulate(City $city, int $last_tick): City
    {
        $delta = floor(Carbon::createFromTimestamp($last_tick)->diffInMinutes(now()));

        $biome = $city->biome;

        $city->buildings->each(function ($level, $buildingKey) use ($biome, $city, $delta) {
            $building = new Building($buildingKey, $level);

            $city->resources = $city->resources->map(function($qty, $resourceKey) use ($biome, $building, $delta) {
                if ($resourceKey === $building->produces()) {
                    $resourceGenerated = ($building->baseResourcePerMinute() * $delta) * $biome->multiplierFor($resourceKey);

                    $newQty = $qty + $resourceGenerated;

                    return floor($newQty);
                }

                return $qty;
            });
        });

        return $city;
    }
}
