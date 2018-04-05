<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * 2Checkout Complete Purchase Request.
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    /**
     * {@inheritdoc}
     *
     * @return mixed
     *
     * @throws InvalidResponseException
     */
    public function getData()
    {
        // if 2co didn't send a POST body parameters, use sent GET string parameters instead.
        // Note: when redirect is set to Header redirect in 2co dashboard, transaction parameters are GET query string.
        $fetchPostBody = $this->httpRequest->request->all();
        if (empty($fetchPostBody)) {
            $request_type = 'query';
        } else {
            $request_type = 'request';
        }

        $orderNo = $this->httpRequest->$request_type->get('order_number');
        $orderAmount = $this->httpRequest->$request_type->get('total');

        // strange exception specified by 2Checkout
        if ($this->getDemoMode()) {
            $orderNo = '1';
        }

        $key = md5($this->getSecretWord().$this->getAccountNumber().$orderNo.$orderAmount);
        if (strtolower($this->httpRequest->$request_type->get('key')) !== $key) {
            throw new InvalidResponseException('Invalid key');
        }

        return $this->httpRequest->$request_type->all();
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $data
     *
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
