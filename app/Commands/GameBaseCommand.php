<?php

namespace App\Commands;

use App\Engine\GameEngine;
use App\Storage\Save;
use LaravelZero\Framework\Commands\Command;

abstract class GameBaseCommand extends Command
{
   public function __construct()
   {
        parent::__construct();

        if (Save::exists()) {
            GameEngine::tick();
        }
   }
}
