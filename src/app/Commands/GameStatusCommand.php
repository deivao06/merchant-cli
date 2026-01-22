<?php

namespace App\Commands;

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
        //@TODO: show city status and resources
        $this->table(
            ['Name', 'Email'],
            [
                ['name' => 'Ddvd', 'email' => 'dvd@emaik.coim'],
                ['name' => 'Ddvd', 'email' => 'dvd@emaik.coim']
            ]
        );
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
