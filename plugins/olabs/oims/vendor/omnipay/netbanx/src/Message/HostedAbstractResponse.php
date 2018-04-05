<?php

namespace Omnipay\NetBanx\Message;

abstract class HostedAbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        $successful = (isset($this->data['transaction']['status'])
            && $this->data['transaction']['status'] == 'success');

        return !$this->isRedirect() && !isset($this->data['error']) && $successful;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        $message = null;

        if (isset($this->data['transaction']['confirmationNumber'])) {
            $message = $this->data['transaction']['confirmationNumber'];
        }

        if (isset($this->data['transaction']['errorMessage'])) {
            $message = $this->data['transaction']['errorMessage'];
        }

        if (isset($this->data['error']['message'])) {
            $message = $this->data['error']['message'];
        }

        return $message;
    }

    /**
     * @return string|null
     */
    public function getCode()
    {
        $code = null;

        if (isset($this->data['transaction']['errorCode'])) {
            $code = $this->data['transaction']['errorCode'];
        }

        if (isset($this->data['error']['code'])) {
            $code = $this->data['error']['code'];
        }

        return $code;
    }

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }
}
