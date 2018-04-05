<?php namespace Olabs\Principles\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Olabs\Tenant\Classes\Tenant;
class Principles extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Principles', 'main-menu-item');
    }


    public function listExtendQuery($query)
    {
        if (!$this->user->hasAnyAccess(['rainlab.blog.access_other_posts'])) {
            $query->where('user_id', $this->user->id);
        }

        $query->where('tenant_id', Tenant::getUserOrgId());

        /*$org = Tenant::getOrg();
        if($org){

            $query->where('tenant_id', $org->id);
        }*/

    }

    public function formExtendQuery($query)
    {
        if (!$this->user->hasAnyAccess(['rainlab.blog.access_other_posts'])) {
            $query->where('user_id', $this->user->id);
        }

        $query->where('tenant_id', Tenant::getUserOrgId());
    }
}