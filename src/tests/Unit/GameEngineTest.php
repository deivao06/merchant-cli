<?php

use App\Engine\GameEngine;
use App\Game\City;

it('may bootstrap the game an return a city class', function () {
    $city = GameEngine::bootstrap('Buenos Aires');

    expect($city)->toBeInstanceOf(City::class);
    expect($city->name)->toBe('Buenos Aires');
});
