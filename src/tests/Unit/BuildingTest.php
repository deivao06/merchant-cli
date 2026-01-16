<?php

use App\Game\Building;

dataset('buildings', ['farm', 'sawmill', 'quarry']);

it('may create building class', function(string $buildingKey) {
    $buildingClass = new Building($buildingKey);
    $buildingConfig = config('buildings')[$buildingKey];

    expect($buildingClass)->toBeInstanceOf(Building::class);
    expect($buildingClass->key)->toBe($buildingKey);
    expect($buildingClass->name())->toBe($buildingConfig['name']);
    expect($buildingClass->produces())->toBe($buildingConfig['produces']);
    expect($buildingClass->baseResourcePerMinute())->toBe($buildingConfig['base_per_minute']);
})->with('buildings');

it('returns default buildings', function () {
    expect(Building::defaultBuildings()->toArray())
        ->toBe([
            'farm' => 1,
            'sawmill' => 1,
            'quarry' => 1
        ]);
});

it('throws exception for unknown building', function () {
    new Building('church');
})->throws(\InvalidArgumentException::class, 'Unknown building: church');

test('building upgrade cost by level', function (string $buildingKey) {
    $level = rand(1, 5);
    $building = new Building($buildingKey, $level);
    $buildingConfig = config('buildings')[$buildingKey];
    $expectedUpgradeCost = $buildingConfig['upgrade_cost']($level);

    expect($building->upgradeCost())->toBeArray();
    expect($building->upgradeCost())->toBe($expectedUpgradeCost);
})->with('buildings');
