<?php

use App\Engine\GameEngine;
use App\Game\City;
use App\Storage\Save;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use function Illuminate\Support\now;

it('may bootstrap the game an return a city class', function () {
    Storage::fake();

    $city = GameEngine::bootstrap('Buenos Aires');

    expect($city)->toBeInstanceOf(City::class);
    expect($city->name)->toBe('Buenos Aires');
    expect(Save::exists())->toBeTrue();
});

it('may simulate resource generation through time', function() {
    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    GameEngine::bootstrap('Nova Lucinda');

    expect(Save::exists())->toBeTrue();

    $this->travel(10)->minutes();

    GameEngine::tick();

    $updatedFile = Save::load();
});
