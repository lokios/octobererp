<?php

namespace Omnipay\Buckaroo;

/**
 * Buckaroo SEPA Direct Debit Gateway
 */
class SepaDirectDebitGateway extends BuckarooGateway
{
    public function getName()
    {
        return 'Buckaroo SepaDirectDebit';
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Buckaroo\Message\SepaDirectDebitPurchaseRequest', $parameters);
    }
}
