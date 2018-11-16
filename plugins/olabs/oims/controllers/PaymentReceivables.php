<?php namespace Olabs\Oims\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Log;
use Backend;
use Olabs\Oims\Models\Status;

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
    
    
    public function onSubmitForApproval() {
        $id = post('id');

        $model = \Olabs\Oims\Models\PaymentReceivable::find($id);

        $model->comment = post('comment');

        $msg = $model->onSubmitForApproval();

        if ($msg['s']) {

            Flash::success($msg['m']);
            $redirectUrl = 'olabs/oims/paymentreceivables/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onApproved() {
        $id = post('id');

        $model = \Olabs\Oims\Models\PaymentReceivable::find($id);

        $model->comment = post('comment');

        $msg = $model->onApproved();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/paymentreceivables/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onRejected() {
        $id = post('id');

        $model = \Olabs\Oims\Models\PaymentReceivable::find($id);

        $model->comment = post('comment');

        $msg = $model->onRejected();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/paymentreceivables/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onSubmitForHOApproval() {
        $id = post('id');

        $model = \Olabs\Oims\Models\PaymentReceivable::find($id);

        $model->comment = post('comment');

        $msg = $model->onSubmitForHOApproval();

        if ($msg['s']) {

            Flash::success($msg['m']);
            $redirectUrl = 'olabs/oims/paymentreceivables/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onHOApproved() {
        $id = post('id');

        $model = \Olabs\Oims\Models\PaymentReceivable::find($id);

        $model->comment = post('comment');

        $msg = $model->onHOApproved();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/paymentreceivables/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onHORejected() {
        $id = post('id');

        $model = \Olabs\Oims\Models\PaymentReceivable::find($id);

        $model->comment = post('comment');

        $msg = $model->onHORejected();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/paymentreceivables/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }
    
    
    //handle back date entry :

    public function formExtendFields($form) {

        //Get if field have already value (EDIT MODE)
        $contextDate = isset($form->data->attributes['context_date']) ? $form->data->attributes['context_date'] : false;
        if ($form->removeField('context_date')) {


            // Handle context date field        
            if ($this->user->isAdmin() OR $this->user->hasAccess('olabs.oims.record_back_date_entry')) {
                //Is Admin OR have back Date date entry permission
                $form->addFields([
                    'context_date' => [
                        'label' => 'Date',
                        'oc.commentPosition' => '',
                        'mode' => 'date',
                        'span' => 'auto',
                        'format' => 'd/m/Y',
                        'required' => 1,
                        'type' => 'datepicker',
                        'default' => 'today',
                        'attributes' => [
                        ]
                    ]
                ]);
            } else {
                //Dont have back date entry permission
                if ($contextDate && date('Y-m-d H:i:s', strtotime($contextDate)) >= date('Y-m-d 00:00:00', strtotime('today'))) {
                    //Make Readonly
                    $form->addFields([
                        'context_date' => [
                            'label' => 'Date',
                            'oc.commentPosition' => '',
                            'mode' => 'date',
                            'span' => 'auto',
                            'default' => 'today',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'minDate' => 'today',
                            'attributes' => [
                            ]
                        ]
                    ]);
                } else if (!$contextDate) {
                    $form->addFields([
                        'context_date' => [
                            'label' => 'Date',
                            'oc.commentPosition' => '',
                            'mode' => 'date',
                            'span' => 'auto',
                            'default' => 'today',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'minDate' => 'today',
                            'attributes' => [
                            ]
                        ]
                    ]);
                } else {
                    $form->addFields([
                        'context_date' => [
                            'label' => 'Date',
                            'oc.commentPosition' => '',
                            'mode' => 'date',
                            'span' => 'auto',
                            'default' => 'today',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'attributes' => [
                                'disabled' => true,
                            ]
                        ]
                    ]);
                }
            }
        }
    }
}