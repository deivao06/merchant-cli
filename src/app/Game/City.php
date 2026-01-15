<?php

namespace App\Game;

use Illuminate\Support\Collection;
use JsonSerializable;

class City implements JsonSerializable
{
    public Biome $biome;
    public Collection $buildings;
    public Collection $resources;

    public function __construct(
        public string $name,
        ?Biome $biome = null,
        ?Collection $buildings = null,
        ?Collection $resources = null
    ) {
        $this->biome = $biome ?? Biome::random();
        $this->buildings = $buildings ?? Building::defaultBuildings();
        $this->resources = $resources ?? Resource::initialResourcePack();
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
