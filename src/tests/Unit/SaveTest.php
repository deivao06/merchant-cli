<?php

use App\Game\City;
use App\Storage\Save;
use Illuminate\Support\Facades\Storage;

it('may create save file', function () {
    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    $city = new City('Luznova');

    Save::write($city);

    Storage::assertExists(Save::FILENAME);
});

it('may load save file', function() {
    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    $city = new City('Luznova');

    Save::write($city);

    Storage::assertExists(Save::FILENAME);

    $content = Save::load();

    expect($content)->toBeInstanceOf(City::class);
    expect($content->name)->toBe('Luznova');
});

it('may mount save payload from city class', function() {
    $city = new City('Luznova');
    $expectedPayload = [
        'city' => [
            'name' => $city->name,
            'biome' => $city->biome->key,
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
    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    $city = new City('Luznova');

    expect(Save::exists())->toBeFalse();

    Save::write($city);

    Storage::assertExists(Save::FILENAME);

    expect(Save::exists())->toBeTrue();
});

it('may get save file content', function () {
    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    $city = new City('Luznova');

    Save::write($city);

    Storage::assertExists(Save::FILENAME);

    $content = Save::getSaveFileContent();

    expect($content)
        ->toBeArray()
        ->toHaveKeys(['city', 'last_tick']);
});

it('may get save file last tick', function() {
    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    $city = new City('Luznova');

    Save::write($city);

    Storage::assertExists(Save::FILENAME);

    $last_tick = Save::last_tick();

    expect($last_tick)
        ->toBeInt()
        ->toBe(\Carbon\Carbon::now()->timestamp);
});
