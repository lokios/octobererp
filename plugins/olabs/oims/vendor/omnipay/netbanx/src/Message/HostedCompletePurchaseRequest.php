<?php

namespace Omnipay\NetBanx\Message;

class HostedCompletePurchaseRequest extends HostedAbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $this->validate('transactionReference');

        $data = parent::getBaseData();

        $data['transactionReference'] = $this->getTransactionReference();

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return HostedPurchaseResponse
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($this->getEndpointAction(), null, 'GET');
        $responseData = json_decode($httpResponse->getBody(true), true);

        return $this->response = new HostedPurchaseResponse($this, $responseData);
    }

    /**
     * @return string
     */
    public function getEndpointAction()
    {
        return "/orders/".$this->getTransactionReference();
    }
}
