<?php

namespace Omnipay\PaymentExpress\Message;

/**
 * PaymentExpress PxPost Create Credit Card Request
 */
class PxPayCreateCardRequest extends PxPayAuthorizeRequest
{
    public function getAction()
    {
        return $this->getParameter('action');
    }

    public function setAction($value)
    {
        return $this->setParameter('action', $value);
    }

    public function getData()
    {
        $this->setAmount($this->getAmount() ? $this->getAmount() : '1.00');


        if ($this->getAction()) {
            $this->action = $this->getAction();
        }

        $data = parent::getData();
        $data->EnableAddBillCard = 1;

        return $data;
    }
}
