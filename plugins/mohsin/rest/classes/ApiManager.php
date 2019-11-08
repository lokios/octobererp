<?php namespace Mohsin\Rest\Classes;

use Schema;
use ApplicationException;
use Mohsin\Rest\Models\Node;
use Mohsin\Rest\Models\Setting;
use System\Classes\PluginManager;

/**
 * Manages all the API nodes.
 *
 * @package Mohsin.Rest
 * @author Saifur Rahman Mohsin
 */
class ApiManager
{
    use \October\Rain\Support\Traits\Singleton;
    use \October\Rain\Extension\ExtendableTrait;

    /**
     * @var collection Cache of the registered API nodes.
     */
    protected $nodes = [];

    /**
     * @var October\Rain\Router\CoreRouter
     */
    protected $router;

    /**
     * @var System\Classes\PluginManager
     */
    protected $pluginManager;

    /**
     * @var API prefix
     * TODO: Replace with customizable value.
     */
    protected $prefix;

    /**
     * Initialize this singleton.
     */
    protected function init()
    {
        $this->pluginManager = PluginManager::instance();
        $this->router = app()->router;

        $this->prefix = Setting::get('prefix', 'api/v1/');

        if (!Schema::hasTable('mohsin_rest_nodes')) {
            return;
        }

        $this->discoverNewNodes();
        $this->registerApiNodes();
    }

    /**
     * Registers the API nodes exposed by various plugins
     * @return void
     */
    public function discoverNewNodes()
    {
        $plugins = $this->pluginManager->getPlugins();

        foreach ($plugins as $id => $plugin) {
            if (!method_exists($plugin, 'registerNodes')) {
                continue;
            }

            $nodes = $plugin->registerNodes();
            if (!is_array($nodes)) {
                continue;
            }

            $this->registerNodes($id, $nodes);
        }
    }

    /**
     * Registers the API nodes exposed by a plugin into the system.
     * The argument is an array of the nodes and their configurations.
     * @param string $owner Specifies the menu items owner plugin or module in the format Author.Plugin.
     * @param array $nodes An array of the nodes the plugin exposes.
     * @return void
     */
    public function registerNodes($owner, array $nodes)
    {
        foreach ($nodes as $path => $config) {
            $node = (object) [
                'owner'   => $owner,
                'path'    => $path,
                'disable' => false,
                'config'  => $config,
            ];

            if (($existingNode = Node::where('path', '=', $path)->first())) {
                if ($existingNode->is_disabled) {
                    $node->disable = true;
                }
            } else {
                Node::create(['path' => $node->path, 'owner' => $node->owner]);
            }

            $this->nodes[$path] = $node;
        }
    }

    /**
     * Register the API nodes with the app router
     * @return void
     */
    protected function registerApiNodes()
    {
        foreach ($this->nodes as $node) {
            $this->registerNodesWithRouter($node);
        }
    }

    public function registerNodesWithRouter(object $node)
    {
        if ($node->disable) {
            return;
        }

        $path = (string) $node->path;
        $config = (object) $node->config;

        $controller = explode('@', $config->controller);
        $path = $this->prefix . $path;
        $options = (array) $config;

        if (count($controller) == 1) {
            $controller = $controller[0];
            $this->router->apiResource($path, $controller, $options);
        } else {
            $options['uses'] = $config->controller;
            switch ($config->action) {
                case 'index':
                case 'create':
                case 'show':
                case 'edit':
                    $this->router->get($path, $options);
                    break;
                case 'store':
                    $this->router->post($path, $options);
                    break;
                case 'update':
                    $this->router->put($path, $options);
                    $this->router->patch($path, $options);
                    break;
                case 'destroy':
                    $this->router->delete($path, $options);
                    break;
                default:
                    throw new ApplicationException(sprintf('Invalid action is route %s', $path));
            }
        }
    }

    public function getPrefix()
    {
        return $this->prefix;
    }
}
