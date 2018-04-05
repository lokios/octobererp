<?php

namespace Omnipay\NetBanx;

use Omnipay\Common\AbstractGateway;

/**
 * NetBanx Hosted Payment Class
 *
 */
class HostedGateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'NetBanx Hosted Payments';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'keyId'       => '',
            'keyPassword' => '',
            'testMode'    => false
        );
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\NetBanx\Message\HostedAuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\NetBanx\Message\HostedAuthorizeRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\NetBanx\Message\HostedPurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\NetBanx\Message\HostedCompleteAuthorizeRequest
     */
    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\NetBanx\Message\HostedCompleteAuthorizeRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\NetBanx\Message\HostedCompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\NetBanx\Message\HostedCompletePurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\NetBanx\Message\HostedCaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\NetBanx\Message\HostedCaptureRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\NetBanx\Message\HostedRefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\NetBanx\Message\HostedRefundRequest', $parameters);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setKeyId($value)
    {
        return $this->setParameter('keyId', $value);
    }

    /**
     * @return mixed
     */
    public function getKeyId()
    {
        return $this->getParameter('keyId');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setKeyPassword($value)
    {
        return $this->setParameter('keyPassword', $value);
    }

    /**
     * @return mixed
     */
    public function getKeyPassword()
    {
        return $this->getParameter('keyPassword');
    }
}
