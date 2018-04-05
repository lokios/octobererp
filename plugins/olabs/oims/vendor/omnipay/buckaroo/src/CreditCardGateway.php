<?php

namespace Omnipay\Buckaroo;

use Omnipay\Common\AbstractGateway;

/**
 * Buckaroo Credit Card Gateway
 */
class CreditCardGateway extends BuckarooGateway
{
    public function getName()
    {
        return 'Buckaroo Credit Card';
    }

    public function getPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    public function setPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Buckaroo\Message\CreditCardPurchaseRequest', $parameters);
    }
}
