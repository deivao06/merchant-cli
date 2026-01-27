<?php

return [
    'farm' => [
        'name' => 'Farm',
        'produces' => 'food',
        'base_per_minute' => 3,
        'upgrade_cost' => fn ($level) => [
            'wood' => 40 * $level,
            'stone' => 30 * $level,
        ],
    ],
    'sawmill' => [
        'name' => 'Sawmill',
        'produces' => 'wood',
        'base_per_minute' => 4,
        'upgrade_cost' => fn ($level) => [
            'food' => 35 * $level,
            'stone' => 30 * $level,
        ],
    ],
    'quarry' => [
        'name' => 'Quarry',
        'produces' => 'stone',
        'base_per_minute' => 2,
        'upgrade_cost' => fn ($level) => [
            'food' => 60 * $level,
            'wood' => 45 * $level,
        ],
    ],
];
