<?php

use App\Storage\Save;
use Illuminate\Support\Facades\Storage;

it('verifies missing save file', function () {
    Storage::fake();
    Storage::assertMissing(Save::FILENAME);

    $this->artisan('game:status')
        ->assertExitCode(1);
});
