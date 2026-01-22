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
            self::mountSavePayloadFromCity($city)
        );
    }

    public static function load(): City
    {
        $content = self::getSaveFileContent();
        return City::fromSaveFile($content);
    }

    public static function exists(): bool
    {
        return Storage::exists(self::FILENAME);
    }

    public static function getSaveFileContent(): array
    {
        $saveFileContent = Storage::get(self::FILENAME);
        return json_decode($saveFileContent, true);
    }

    public static function mountSavePayloadFromCity(City $city): string
    {
        $payload = [
            'city' => $city->jsonSerialize(),
            'last_tick' => Carbon::now('UTC')->timestamp
        ];

        return json_encode($payload);
    }

    public static function last_tick(): int
    {
        return self::getSaveFileContent()['last_tick'];
    }
}
