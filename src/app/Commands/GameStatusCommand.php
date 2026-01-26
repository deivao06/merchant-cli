<?php

namespace App\Commands;

use App\Game\City;
use App\Storage\Save;
use Illuminate\Console\Scheduling\Schedule;

class GameStatusCommand extends GameBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show your city status and resources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!Save::exists()) {
            $this->fail("You don't have a city yet! try creating a city using game:init command");
        }

        $this->statusMessage(Save::load());
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }

    private function statusMessage(City $city): void
    {
        $this->newLine();
        $this->info("{$city->name}");
        $this->info("Biome: {$city->biome->name()}");
        $this->warn('Buildings:');
        $city->buildings->each(fn ($qty, $building) =>
            $this->line("   $building: $qty")
        );
        $this->warn('Resources:');
        $city->resources->each(fn ($qty, $resource) =>
            $this->line("   $resource: $qty")
        );
        $this->newLine();
    }
}
