<?php namespace Olabs\Tenant\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Members extends Controller
{
    public $implement = [];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Tenant', 'main-menu-item', 'side-menu-item4');
    }
}