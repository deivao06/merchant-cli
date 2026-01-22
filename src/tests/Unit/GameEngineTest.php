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
