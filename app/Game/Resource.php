<?php

namespace App\Game;

use Illuminate\Support\Collection;

class Resource
{
    public string $key;
    private Collection $data;

    public function __construct(string $resourceKey)
    {
        if (!self::resources()->has($resourceKey)) {
            throw new \InvalidArgumentException("Unknown resource: $resourceKey");
        }

        $this->key = $resourceKey;
        $this->data = collect(self::resources()->get($resourceKey));
    }

    public static function resources(): Collection
    {
        return collect(config('resources'));
    }

    public static function initialResourcePack(): Collection
    {
        return self::resources()
            ->mapWithKeys(fn ($resource, $key) => [$key => ($resource['tradeable'] ? 100 : 0)]);
    }

    public function name(): string
    {
        return $this->data->get('name');
    }

    public function tradeable(): bool
    {
        return $this->data->get('tradeable');
    }
}
