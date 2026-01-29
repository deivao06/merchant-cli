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
                'farm' => [
                    'key' => 'farm',
                    'level' => 1,
                ],
                'sawmill' => [
                    'key' => 'sawmill',
                    'level' => 1,
                ],
                'quarry' => [
                    'key' => 'quarry',
                    'level' => 1,
                ],
            ],
            'resources' => [
                'gold' => [
                    'key' => 'gold',
                    'qty' => 0,
                ],
                'food' => [
                    'key' => 'food',
                    'qty' => 100,
                ],
                'wood' => [
                    'key' => 'wood',
                    'qty' => 100,
                ],
                'stone' => [
                    'key' => 'stone',
                    'qty' => 100,
                ],
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
        ->toBe(\Carbon\Carbon::now('UTC')->timestamp);
});
