<?php

namespace Autumn\Api\Console;

use Str;
use Route;
use Exception;
use October\Rain\Scaffold\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateApi extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create api controller and transformer for a given model.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'API';

    /**
     * A mapping of stub to generated file.
     *
     * @var array
     */
    protected $stubs = [
        'api/controller.stub' => 'http/controllers/{{studly_controller}}.php',
        'api/transformer.stub' => 'http/transformers/{{studly_transformer}}.php',
        'api/routes.stub' => 'routes.php',
    ];

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        parent::fire();

        $routeExists = Route::has(
            'api.v1.'.$this->vars['lower_controller'].'.index'
        );

        if (! $routeExists) {
            $this->addRoute();
        }
    }

    /**
     * Make a single stub.
     *
     * @param string $stubName The source filename for the stub.
     */
    public function makeStub($stubName)
    {
        try {
            parent::makeStub($stubName);
        } catch (Exception $e) {
            return;
        }
    }

    /**
     *  Add routes to routes file.
     */
    protected function addRoute()
    {
        $stubName = 'api/route.stub';

        $sourceFile = $this->getSourcePath().'/'.$stubName;
        $destinationFile = $this->getDestinationPath().'/routes.php';
        $destinationContent = $this->files->get($sourceFile);

        /*
         * Parse each variable in to the destination content and path
         */
        foreach ($this->vars as $key => $var) {
            $destinationContent = str_replace('{{'.$key.'}}', $var, $destinationContent);
            $destinationFile = str_replace('{{'.$key.'}}', $var, $destinationFile);
        }

        $this->saveResource($destinationFile, $destinationContent);
    }

    /**
     * Prepare variables for stubs.
     *
     * return @array
     */
    protected function prepareVars()
    {
        $pluginCode = $this->argument('plugin');

        $parts = explode('.', $pluginCode);
        $plugin = array_pop($parts);
        $author = array_pop($parts);

        $model = $this->argument('model');
        $transformer = $model.'Transformer';

        /*
         * Determine the controller name to use.
         */
        $controller = $this->option('controller');
        if (! $controller) {
            $controller = Str::plural($model);
        }

        return [
            'model' => $model,
            'author' => $author,
            'plugin' => $plugin,
            'controller' => $controller,
            'transformer' => $transformer,
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of the plugin to create. Eg: RainLab.Blog'],
            ['model', InputArgument::REQUIRED, 'The name of the model. Eg: Post'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite existing files with generated ones.'],
            ['controller', null, InputOption::VALUE_OPTIONAL, 'The name of the controller. Eg: Posts'],
        ];
    }

    /**
     * Save the given resource to the given routes file.
     *
     * @param string $destinationFile
     * @param string $destinationContent
     */
    protected function saveResource($destinationFile, $destinationContent)
    {
        // read file
        $lines = file($destinationFile);
        $lastLine = trim($lines[count($lines) - 1]);

        // modify file
        if (strcmp($lastLine, '});') === 0) {
            $lines[count($lines) - 1] = '    '.$destinationContent;
            $lines[] = "\r\n});\r\n";
        } else {
            $lines[] = "$destinationContent\r\n";
        }

        // save file
        $fp = fopen($destinationFile, 'w');

        fwrite($fp, implode('', $lines));
        fclose($fp);
    }
}
