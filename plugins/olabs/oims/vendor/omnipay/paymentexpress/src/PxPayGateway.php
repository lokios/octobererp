<?php

namespace Omnipay\PaymentExpress;

use Omnipay\Common\AbstractGateway;
use Omnipay\PaymentExpress\Message\PxPayAuthorizeRequest;
use Omnipay\PaymentExpress\Message\PxPayCompleteAuthorizeRequest;
use Omnipay\PaymentExpress\Message\PxPayPurchaseRequest;
use Omnipay\Omnipay;

/**
 * DPS PaymentExpress PxPay Gateway
 */
class PxPayGateway extends AbstractGateway
{
    public function getName()
    {
        return 'PaymentExpress PxPay';
    }

    public function getDefaultParameters()
    {
        return array(
            'username' => '',
            'password' => '',
            'pxPostUsername' => '',
            'pxPostPassword' => '',
            'testMode' => false,
        );
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getPxPostUsername()
    {
        return $this->getParameter('pxPostUsername');
    }

    public function setPxPostUsername($value)
    {
        return $this->setParameter('pxPostUsername', $value);
    }


    public function getPxPostPassword()
    {
        return $this->getParameter('pxPostPassword');
    }

    public function setPxPostPassword($value)
    {
        return $this->setParameter('pxPostPassword', $value);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PaymentExpress\Message\PxPayAuthorizeRequest', $parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PaymentExpress\Message\PxPayCompleteAuthorizeRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        if (!empty($parameters['cardReference']) && $this->getPxPostPassword() && $this->getPxPostUsername()) {
            $gateway = Omnipay::create('PaymentExpress_PxPost');
            $gateway->setPassword($this->getPxPostPassword());
            $gateway->setUserName($this->getPxPostUsername());
            return $gateway->purchase($parameters);
        }
        return $this->createRequest('\Omnipay\PaymentExpress\Message\PxPayPurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->completeAuthorize($parameters);
    }

    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PaymentExpress\Message\PxPayCreateCardRequest', $parameters);
    }

    public function completeCreateCard(array $parameters = array())
    {
        return $this->completeAuthorize($parameters);
    }
}
