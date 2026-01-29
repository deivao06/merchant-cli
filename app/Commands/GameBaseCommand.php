<?php

namespace App\Commands;

use App\Engine\GameEngine;
use App\Game\Building;
use App\Game\Resource;
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

    protected function buildingInfoMessage(Building $building): void
    {
        $this->line("- {$building->name()} (lvl): $building->level");
    }

    protected function resourceInfoMessage(Resource $resource): void
    {
        $this->line("- {$resource->name()} (qty): $resource->qty");
    }
}
