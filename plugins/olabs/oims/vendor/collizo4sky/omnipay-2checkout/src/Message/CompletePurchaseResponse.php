<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * 2Checkout Complete Purchase Response.
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return true;
    }

    /**
     * Transaction ference returned by 2checkout or null on payment failure.
     *
     * @return mixed|null
     */
    public function getTransactionReference()
    {
        return isset($this->data['order_number']) ? $this->data['order_number'] : null;
    }

    /**
     * Transaction ID.
     *
     * @return mixed|null
     */
    public function getTransactionId()
    {
        return isset($this->data['merchant_order_id']) ? $this->data['merchant_order_id'] : null;
    }
}
