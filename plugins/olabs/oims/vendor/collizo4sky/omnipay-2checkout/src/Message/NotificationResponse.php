<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\AbstractResponse;

class NotificationResponse extends AbstractResponse implements NotificationInterface
{
    /**
     * Is the notification harsh correct after validation?
     */
    public function isSuccessful()
    {
        # Validate the Hash
        $hashSecretWord = $this->data['secretWord']; # Input your secret word
        $hashSid = $this->data['accountNumber']; #Input your seller ID (2Checkout account number)
        $hashOrder = $this->data['sale_id'];
        $hashInvoice = $this->data['invoice_id'];
        $StringToHash = strtoupper(md5($hashOrder.$hashSid.$hashInvoice.$hashSecretWord));

        return $StringToHash == $this->data['md5_hash'];
    }

    /**
     * 2Checkout transaction reference.
     *
     * @return mixed
     */
    public function getTransactionReference()
    {
        return $this->data['sale_id'];
    }

    /**
     * Order or transaction ID.
     *
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->data['vendor_order_id'];
    }

    /**
     * Indicate what type of 2Checkout notification this is.
     *
     * @return string
     */
    public function getNotificationType()
    {
        return $this->data['message_type'];
    }

    /**
     * Get transaction/notification status.
     *
     * SInce this is an IPN notification, we made this true.
     *
     * @return bool
     */
    public function getTransactionStatus()
    {
        return true;
    }

    /**
     * Notification response.
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->data;
    }
}
