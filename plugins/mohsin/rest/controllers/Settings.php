<?php namespace Mohsin\Rest\Controllers;

use Lang;
use Flash;
use BackendMenu;
use Backend\Classes\Controller;
use Mohsin\Rest\Models\Node;
use System\Classes\SettingsManager;
use System\Controllers\Settings as SettingsController;

/**
 * Settings Back-end Controller
 */
class Settings extends SettingsController
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Mohsin.Rest', 'settings');
    }

    public function index()
    {
        parent::index();
        $model = $this->formCreateModelObject();
        $this->update('Mohsin', 'Rest', 'settings');
        return $this->asExtension('ListController')->index();
    }

    public function onSave()
    {
        return $this->update_onSave('Mohsin', 'Rest', 'settings');
    }

    protected function createModel($item)
    {
        return \Mohsin\Rest\Models\Setting::instance();
    }

    public function onBulkAction()
    {
        if (($bulkAction = post('action')) &&
            ($checkedIds = post('checked')) &&
            is_array($checkedIds) &&
            count($checkedIds)
        ) {
            foreach ($checkedIds as $nodeId) {
                if (!$node = Node::find($nodeId)) {
                    continue;
                }

                switch ($bulkAction) {
                    // Disables nodes exposed by the system.
                    case 'disable':
                        $node->disable();
                        break;

                    // Enables nodes exposed by the system.
                    case 'enable':
                        $node->enable();
                        break;
                }
            }
        }
        Flash::success(Lang::get("mohsin.rest::lang.settings.{$bulkAction}_success"));
        return $this->listRefresh('manage');
    }
}
