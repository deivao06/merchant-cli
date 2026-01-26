<?php

namespace App\Commands;

use App\Engine\GameEngine;
use App\Game\City;
use App\Storage\Save;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class GameInitCommand extends GameBaseCommand implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:init
                            {cityName : The name of the city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init the game and create your city';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (Save::exists()) {
            $this->fail('You already have a city.');
        }

        $cityName = $this->argument('cityName');

        $city = GameEngine::bootstrap($cityName);

        //TODO: start beacon for city discovery through LAN

        $this->welcomeMessage($city);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'cityName' => 'What is the city name?',
        ];
    }

    private function welcomeMessage(City $city): void
    {
        $this->newLine();
        $this->info('Welcome, Merchant.');
        $this->info('Your city has been founded.');
        $this->newLine();
        $this->info("Name: {$city->name}");
        $this->info("Biome: {$city->biome->name()}");
        $this->newLine();
        $this->warn('Starting buildings:');
        $city->buildings->each(fn ($qty, $building) =>
            $this->line("$building: $qty")
        );
        $this->newLine();
        $this->warn('Starting resources:');
        $city->resources->each(fn ($qty, $resource) =>
            $this->line("$resource: $qty")
        );
        $this->newLine();
    }
}
