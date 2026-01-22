<?php

namespace App\Commands;

use App\Engine\GameEngine;
use App\Game\City;
use App\Storage\Save;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use LaravelZero\Framework\Commands\Command;

class GameInitCommand extends Command implements PromptsForMissingInput
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

        Save::write($city);

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
        $this->line('Welcome, Merchant.');
        $this->newLine();
        $this->line('Your city has been founded.');
        $this->newLine();
        $this->line("Name: {$city->name}");
        $this->line("Biome: {$city->biome->name()}");
        $this->newLine();
        $this->line('Starting buildings:');
        $city->buildings->each(fn ($qty, $building) =>
            $this->line("$building: $qty")
        );
        $this->newLine();
        $this->line('Starting resources:');
        $city->resources->each(fn ($qty, $resource) =>
            $this->line("$resource: $qty")
        );
    }
}
