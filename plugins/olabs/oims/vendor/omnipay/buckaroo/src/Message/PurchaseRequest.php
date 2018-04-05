<?php

namespace Omnipay\Buckaroo\Message;

/**
 * Buckaroo Purchase Request.
 *
 * With this purchase request Buckaroo will show all payment options configured for the website (websiteKey).
 * The user must choose the payment method on the Buckaroo page.
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();
        unset($data['Brq_payment_method']);
        unset($data['Brq_service_ideal_issuer']);
        unset($data['Brq_requestedservices']);

        return $data;
    }
}
