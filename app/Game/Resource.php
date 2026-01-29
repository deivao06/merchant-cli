<?php

namespace App\Game;

use Illuminate\Support\Collection;

class Resource
{
    public string $key;
    public int $qty;
    private Collection $data;

    public function __construct(string $resourceKey, ?int $qty = null)
    {
        if (!self::resources()->has($resourceKey)) {
            throw new \InvalidArgumentException("Unknown resource: $resourceKey");
        }

        $this->key = $resourceKey;
        $this->data = collect(self::resources()->get($resourceKey));
        $this->qty = $qty ?? 0;
    }

    public static function resources(): Collection
    {
        return collect(config('resources'));
    }

    public static function initialResourcePack(): Collection
    {
        return self::resources()
            ->mapWithKeys(fn ($resource, $key) =>
                [$key => new self($key, $resource['tradeable'] ? 100 : 0)]
            );
    }

    public function name(): string
    {
        return $this->data->get('name');
    }

    public function tradeable(): bool
    {
        return $this->data->get('tradeable');
    }

    public function add(int $addQty): self
    {
        $this->qty += $addQty;
        return $this;
    }

    public function remove(int $removeQty): self
    {
        $this->qty -= $removeQty;
        return $this;
    }
}
