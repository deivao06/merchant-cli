<?php

return [
    'plains' => [
        'name' => 'Plains',
        'bonus' => [
            'food' => 1.2, // +20%
        ],
        'penalty' => [
            'stone' => 0.7, // -30%
        ],
    ],
    'forest' => [
        'name' => 'Forest',
        'bonus' => [
            'wood' => 1.2, // +20%
        ],
        'penalty' => [
            'food' => 0.7, // -30%
        ],
    ],
    'mountain' => [
        'name' => 'Mountain',
        'bonus' => [
            'stone' => 1.2, // +20%
        ],
        'penalty' => [
            'wood' => 0.7, // -30%
        ],
    ],
];
