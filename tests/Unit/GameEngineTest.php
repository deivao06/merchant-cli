<?php

use App\Engine\GameEngine;
use App\Game\City;
use App\Storage\Save;
use Illuminate\Support\Facades\Storage;

it('may bootstrap the game an return a city class', function () {
    Storage::fake();

    $city = GameEngine::bootstrap('Buenos Aires');

    expect($city)->toBeInstanceOf(City::class);
    expect($city->name)->toBe('Buenos Aires');
    expect(Save::exists())->toBeTrue();
});

it('may simulate resource generation through time', function() {
    $passedMinutes = 10;

    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    GameEngine::bootstrap('Nova Lucinda');

    expect(Save::exists())->toBeTrue();

    $this->travel($passedMinutes)->minutes();

    GameEngine::tick();

    $updatedCity = Save::load();
    $generatedFood = 100 + (config('buildings.farm.base_per_minute') * $passedMinutes) * $updatedCity->biome->multiplierFor('food');
    $generatedWood = 100 + (config('buildings.sawmill.base_per_minute') * $passedMinutes) * $updatedCity->biome->multiplierFor('wood');
    $generatedStone = 100 + (config('buildings.quarry.base_per_minute') * $passedMinutes) * $updatedCity->biome->multiplierFor('stone');

    expect((int) $generatedFood)->toBe($updatedCity->food()->qty);
    expect((int) $generatedWood)->toBe($updatedCity->wood()->qty);
    expect((int) $generatedStone)->toBe($updatedCity->stone()->qty);
});
