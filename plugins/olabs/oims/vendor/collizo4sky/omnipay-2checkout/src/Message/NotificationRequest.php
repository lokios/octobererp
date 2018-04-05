<?php

namespace Omnipay\TwoCheckoutPlus\Message;

class NotificationRequest extends AbstractRequest
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getData()
    {
        $data = $this->httpRequest->request->all();
        $data['secretWord'] = $this->getSecretWord();
        $data['accountNumber'] = $this->getAccountNumber();

        return $data;
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $data
     *
     * @return NotificationResponse
     */
    public function sendData($data)
    {
        return new NotificationResponse($this, $data);
    }
}
