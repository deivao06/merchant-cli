<?php

namespace App\Storage;

use App\Game\City;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Save
{
    const FILENAME = 'save.json';

    public static function write(City $city): void
    {
        Storage::put(
            self::FILENAME,
            json_encode(self::mountSavePayloadFromCity($city))
        );
    }

    public static function load(): void
    {
        //TODO: mount city from json file
    }

    private static function mountSavePayloadFromCity(City $city): string
    {
        $payload = [
            'city' => $city->jsonSerialize(),
            'last_tick' => Carbon::now('UTC')->timestamp
        ];

        return json_encode($payload);
    }
}
