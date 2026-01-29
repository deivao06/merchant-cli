<?php

use App\Game\Resource;

dataset('resources', ['gold', 'wood', 'stone', 'food']);

it('may create resource class', function (string $resourceKey) {
    $resource = new Resource($resourceKey);
    $resourceConfig = config('resources')[$resourceKey];

    expect($resource)->toBeInstanceOf(Resource::class);
    expect($resource->key)->toBe($resourceKey);
    expect($resource->name())->toBeString()->toBe($resourceConfig['name']);
})->with('resources');

it('throws exception for unknown resource', function () {
    new Resource('silver');
})->throws(\InvalidArgumentException::class, 'Unknown resource: silver');

it('returns initial resource pack', function () {
    $initialResourcePack = Resource::initialResourcePack();

    expect($initialResourcePack->some(fn($resource) => $resource instanceof Resource))->toBeTrue();
    expect($initialResourcePack->some(fn($resource) => $resource->tradeable() ? $resource->qty === 100 : $resource->qty === 0))->toBeTrue();
    expect($initialResourcePack->toJson())
        ->toBe('{"gold":{"key":"gold","qty":0},"food":{"key":"food","qty":100},"wood":{"key":"wood","qty":100},"stone":{"key":"stone","qty":100}}');
});
