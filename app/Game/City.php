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

    public static function fromSaveFile(array $saveFileContent): self
    {
        $city = $saveFileContent['city'];

        return new self(
            name: $city['name'],
            biome: new Biome($city['biome']),
            buildings: collect($city['buildings']),
            resources: collect($city['resources']),
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'biome' => $this->biome->key,
            'buildings' => $this->buildings,
            'resources' => $this->resources
        ];
    }

    public function gold(): int
    {
        return $this->resources->get('gold');
    }

    public function food(): int
    {
        return $this->resources->get('food');
    }

    public function wood(): int
    {
        return $this->resources->get('wood');
    }

    public function stone(): int
    {
        return $this->resources->get('stone');
    }
}
