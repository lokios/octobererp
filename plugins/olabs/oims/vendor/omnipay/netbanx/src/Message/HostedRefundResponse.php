<?php

namespace Omnipay\NetBanx\Message;

class HostedRefundResponse extends HostedAbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        $successfulTransaction = (isset($this->data['confirmationNumber'])
            && isset($this->data['authType']) && $this->data['authType'] == 'refund');

        return !isset($this->data['error']) && $successfulTransaction;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        $message = null;

        if (isset($this->data['confirmationNumber'])) {
            $message = $this->data['confirmationNumber'];
        }

        if (isset($this->data['error']['message'])) {
            $message = $this->data['error']['message'];
        }

        return $message;
    }

    /**
     * @return null
     */
    public function getRedirectData()
    {
        return null;
    }
}
