<?php

use App\Game\Resource;
use Illuminate\Support\Collection;

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
    expect(Resource::initialResourcePack()->toArray())
        ->toBe([
            'gold' => 0,
            'food' => 100,
            'wood' => 100,
            'stone' => 100
        ]);
});
