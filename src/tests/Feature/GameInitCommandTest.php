<?php

use App\Storage\Save;
use Illuminate\Support\Facades\Storage;

it('may bootstrap game and create save file', function() {
    Storage::fake();

    $this->artisan('game:init Pindorama');

    Storage::assertExists(Save::FILENAME);

    $content = Storage::get(Save::FILENAME);
    $decodedContent = json_decode($content, true);

    expect($decodedContent)->toBeArray();
    expect($decodedContent['city']['name'])->toBe('Pindorama');
});
