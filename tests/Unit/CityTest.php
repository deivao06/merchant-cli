<?php

use App\Game\Biome;
use App\Game\Building;
use App\Game\City;
use App\Game\Resource;

dataset('cities', ['New Lunova', 'Pindoramalandy', 'COAB43', 'ZL']);

it('may create city class by name', function(string $name) {
    $city = new City($name);

    expect($city)->toBeInstanceOf(City::class);
    expect($city->name)->toBe($name);
    expect($city->biome)->toBeInstanceOf(Biome::class);
    expect($city->buildings->toJson())->toBe(Building::defaultBuildings()->toJson());
    expect($city->resources->toJson())->toBe(Resource::initialResourcePack()->toJson());
})->with('cities');

test('city class json serialize', function() {
    $city = new City('Pindoramalandy');

    expect(json_encode($city))
        ->json()
        ->name->toBe('Pindoramalandy')
        ->biome->toBe($city->biome->key);
});
