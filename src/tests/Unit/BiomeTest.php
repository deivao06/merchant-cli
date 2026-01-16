<?php

use App\Game\Biome;

dataset('biomes', ['plains', 'forest', 'mountain']);
dataset('multipliers', [
    ['plains', [
        'bonus' => [
            'food' => 1.2, // +20%
        ],
        'penalty' => [
            'stone' => 0.7, // -30%
        ],
    ]],
    ['forest', [
        'bonus' => [
            'wood' => 1.2, // +20%
        ],
        'penalty' => [
            'food' => 0.7, // -30%
        ],
    ]],
    ['mountain', [
        'bonus' => [
            'stone' => 1.2, // +20%
        ],
        'penalty' => [
            'wood' => 0.7, // -30%
        ],
    ]],
]);

it('may create biome class', function (string $biomeKey) {
    $biomeClass = new Biome($biomeKey);
    $biomeConfig = config('biomes')[$biomeKey];


    expect($biomeClass)->toBeInstanceOf(Biome::class);
    expect($biomeClass->key)->toBe($biomeKey);
    expect($biomeClass->name())->toBe($biomeConfig['name']);
})->with('biomes');

it('may return biome multiplier by resource', function (string $biomeKey, array $multipliers) {
    $resources = ['food', 'wood', 'stone'];
    $biomeClass = new Biome($biomeKey);

    foreach ($resources as $resource) {
        $multiplier = $biomeClass->multiplierFor($resource);

        $multiplierExpected = $multipliers['bonus'][$resource]
            ?? $multipliers['penalty'][$resource]
            ?? 1.0;

        expect($multiplier)->toBeFloat();
        expect($multiplier)->toBe($multiplierExpected);
    }
})->with('multipliers');

it('may create a random biome class', function () {
    $class = Biome::random();

    expect($class)->toBeInstanceOf(Biome::class);
    expect($class->name())->toBeString();
});
