<?php

namespace App\Commands;

use App\Engine\GameEngine;
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
        //TODO: abort if save file already exists

        $cityName = $this->argument('cityName');
        $city = GameEngine::bootstrap($cityName);

        //TODO: make save file after city

        //TODO: start beacon for city discovery through LAN

        $this->line(json_encode($city));
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
}
