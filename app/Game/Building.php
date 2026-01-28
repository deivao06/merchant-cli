<?php

namespace App\Game;

use Illuminate\Support\Collection;

class Building
{
    public string $key;
    public int $level;
    private Collection $data;

    public function __construct(string $buildingKey, ?int $level = null)
    {
        if (!self::buildings()->has($buildingKey)) {
            throw new \InvalidArgumentException("Unknown building: $buildingKey");
        }

        $this->key = $buildingKey;
        $this->level = $level ?? 1;
        $this->data = collect(self::buildings()->get($buildingKey));
    }

    public static function buildings(): Collection
    {
        return collect(config('buildings'));
    }

    public static function defaultBuildings(): Collection
    {
        return self::buildings()
            ->mapWithKeys(fn ($building, $key) =>
                [$key => new self(buildingKey: $key, level: 1)]
            );
    }

    public function name(): string
    {
        return $this->data->get('name');
    }

    public function produces(): string
    {
       return $this->data->get('produces');
    }

    public function baseResourcePerMinute(): int
    {
        return $this->data->get('base_per_minute');
    }

    public function upgradeCost(): array
    {
        $upgradeCost = $this->data->get('upgrade_cost');

        return $upgradeCost($this->level);
    }
}
