<?php namespace Olabs\Oims\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Input;

/**
 * Payment Gateways Back-end Controller
 */
class PaymentGateways extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];
    
    public $requiredPermissions = ['olabs.oims.paymentgateways'];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'oims_setup', 'paymentgateways');
    }
    
    /**
     * Re-Render partials
     * 
     * @return type
     */
    public function onParametersFieldsValuesRefresh() {
        
        $gateway = Input::get("gateway");
        
        $data = [
            "parameters_fields" => \Olabs\Oims\Models\PaymentGateway::getParametersFieldsStatic($gateway),
            "parameters_values" => [],
            "field_name_prefix" => "PaymentGateway[parameters]",
        ];
        return [
            "#parameters_field_pratial" => $this->makePartial("parameters_field_pratial", $data)
        ];
    }
}