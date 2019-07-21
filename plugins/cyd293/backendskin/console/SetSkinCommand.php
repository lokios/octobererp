<?php

namespace Cyd293\BackendSkin\Console;

use Cyd293\BackendSkin\Classes\Skin;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Description of SetSkinCommand
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class SetSkinCommand extends Command
{
    /**
     * @var string The name of command
     */
    protected $name = "backendskin:skin:set";

    /**
     * @var string Description of the command
     */
    protected $description = "Set the backend skin code";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $code = $this->argument('code');
        Skin::setActiveSkin($code);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            ['code', InputArgument::REQUIRED, 'Code of the skin to be use'],
        ];
    }
}
