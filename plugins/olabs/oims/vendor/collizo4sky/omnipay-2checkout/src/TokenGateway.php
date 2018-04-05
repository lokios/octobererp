<?php

namespace Omnipay\TwoCheckoutPlus;

use Omnipay\Common\AbstractGateway;

/**
 * 2Checkout Token Gateway.
 */
class TokenGateway extends AbstractGateway
{
    public function getName()
    {
        return 'TwoCheckoutPlus_Token';
    }

    public function getDefaultParameters()
    {
        return array(
            'accountNumber' => '',
            'privateKey' => '',
            'testMode' => false,
        );
    }

    /**
     * Getter: 2Checkout account number.
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    /**
     * Setter: 2Checkout account number.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }

    /**
     * Getter: 2Checkout private key.
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    /**
     * Setter: 2Checkout private key.
     *
     * @param $value
     *
     * @return $this
     */
    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * @return Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\TwoCheckoutPlus\Message\TokenPurchaseRequest', $parameters);
    }
}
