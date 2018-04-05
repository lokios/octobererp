<?php

namespace Omnipay\NetBanx\Message;

class HostedRefundRequest extends HostedAbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $this->validate('amount', 'transactionReference', 'transactionId');

        $data = parent::getBaseData();

        $data['amount'] = $this->getAmountInteger();
        $data['merchantRefNum'] = $this->getTransactionId();

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return HostedRefundResponse
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($this->getEndpointAction(), null, 'POST');
        $responseData = json_decode($httpResponse->getBody(true), true);

        return $this->response = new HostedRefundResponse($this, $responseData);
    }

    /**
     * @return string
     */
    public function getEndpointAction()
    {
        return '/orders/'.$this->getTransactionReference().'/refund';
    }
}
