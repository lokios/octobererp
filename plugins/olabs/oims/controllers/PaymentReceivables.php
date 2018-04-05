<?php namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class PaymentReceivables extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'olabs.oims.payment_receivables' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'master_register', 'payment_receivables');
    }
}