<?php

use App\Game\City;
use App\Storage\Save;
use Illuminate\Support\Facades\Storage;

it('may create save file', function () {
    $city = new City('Luznova');

    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    Save::write($city);

    Storage::assertExists(Save::FILENAME);

    $content = Storage::get(Save::FILENAME);
    $decodedContent = json_decode($content, true);

    expect($decodedContent)->toBeArray();
    expect($decodedContent['city']['name'])->toBe('Luznova');
});

it('may mount save payload from city class', function() {
    $city = new City('Luznova');
    $expectedPayload = [
        'city' => [
            'name' => $city->name,
            'biome' => $city->biome->name(),
            'buildings' => [
                'farm' => 1,
                'sawmill' => 1,
                'quarry' => 1,
            ],
            'resources' => [
                'gold' => 0,
                'food' => 100,
                'wood' => 100,
                'stone' => 100,
            ],
        ],
        'last_tick' => Carbon\Carbon::now('UTC')->timestamp
    ];

    expect(Save::mountSavePayloadFromCity($city))
        ->toBe(json_encode($expectedPayload));
});


it('may verify if save file already exists', function() {
    $city = new City('Luznova');

    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    Save::write($city);

    Storage::assertExists(Save::FILENAME);

    expect(Save::exists())->toBeTrue();
});
