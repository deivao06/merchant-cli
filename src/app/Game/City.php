<?php

namespace App\Game;

use Illuminate\Support\Collection;
use JsonSerializable;

class City implements JsonSerializable
{
    public string $name;
    public Biome $biome;
    public Collection $buildings;
    public Collection $resources;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->biome = Biome::random();
        $this->buildings = Building::defaultBuildings();
        $this->resources = Resource::initialResourcePack();
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'biome' => $this->biome->name(),
            'buildings' => $this->buildings,
            'resources' => $this->resources
        ];
    }
}
