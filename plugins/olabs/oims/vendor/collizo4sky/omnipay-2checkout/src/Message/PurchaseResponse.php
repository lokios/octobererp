<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Response.
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $liveEndpoint = 'https://www.2checkout.com/checkout/purchase';
    protected $testEndpoint = 'https://sandbox.2checkout.com/checkout/purchase';

    /**
     * Get appropriate 2checkout endpoints.
     *
     * @return string
     */
    public function getEndPoint()
    {
        if ($this->data['sandbox']) {
            return $this->testEndpoint;
        } else {
            return $this->liveEndpoint;
        }
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        $endpoint = $this->getEndPoint();

        // remove the sandbox parameter.
        unset($this->data['sandbox']);

        $url = $endpoint.'?'.http_build_query($this->data);

        // Fix for some sites that encode the entities
        return str_replace('&amp;', '&', $url);
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * No redirect data.
     */
    public function getRedirectData()
    {
        return;
    }
}
