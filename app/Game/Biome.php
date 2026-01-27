<?php

namespace App\Game;

use Illuminate\Support\Collection;

class Biome
{
    public string $key;
    private Collection $data;

    public function __construct(string $biomeKey)
    {
        if (!self::biomes()->has($biomeKey)) {
            throw new \InvalidArgumentException("Unknown biome: $biomeKey");
        }

        $this->key = $biomeKey;
        $this->data = collect(self::biomes()->get($biomeKey));
    }

    public static function biomes(): Collection
    {
        return collect(config('biomes'));
    }

    public static function random(): self
    {
        $biomes = self::biomes()->keys()->toArray();
        $random = rand(0, count($biomes) - 1);

        return new self($biomes[$random]);
    }

    public function name(): string
    {
        return $this->data->get('name');
    }

    public function multiplierFor(string $resource): float
    {
        $bonus = $this->data->get('bonus');
        $penalty = $this->data->get('penalty');

        if (isset($bonus[$resource])) {
            return $bonus[$resource];
        }

        if (isset($penalty[$resource])) {
            return $penalty[$resource];
        }

        return 1.0;
    }
}
