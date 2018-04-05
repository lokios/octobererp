<?php

namespace Omnipay\NetBanx\Message;

class HostedPurchaseRequest extends HostedAbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $this->validate('amount', 'returnUrl', 'cancelUrl');

        // https://developer.optimalpayments.com/en/documentation/hosted-payment-api/redirect-object/
        $returnUrl = array();
        $returnUrl['rel'] = 'on_success';
        $returnUrl['returnKeys'] = array('id');
        $returnUrl['uri'] = $this->getReturnUrl();

        $errorUrl = array();
        $errorUrl['rel'] = 'on_error';
        $errorUrl['returnKeys'] = array('id', 'transaction.errorMessage');
        $errorUrl['uri'] = $this->getReturnUrl();

        $declineUrl = array();
        $declineUrl['rel'] = 'on_decline';
        $declineUrl['returnKeys'] = array('id', 'transaction.errorMessage');
        $declineUrl['uri'] = $this->getReturnUrl();

        $cancelUrl = array();
        $cancelUrl['rel'] = 'cancel_url';
        $cancelUrl['returnKeys'] = array();
        $cancelUrl['uri'] = $this->getCancelUrl();

        $email = '';
        $emailNotEditable = array('key' => 'emailNotEditable', 'value' => true);

        $card = $this->getCard();
        if ($card) {
            $billingDetails = array();
            $billingDetails['street'] = (string)$card->getBillingAddress1();
            $billingDetails['street2'] = $card->getBillingAddress2();
            $billingDetails['city'] = (string)$card->getBillingCity();
            $billingDetails['state'] = (string)$card->getBillingState();
            $billingDetails['country'] = (string)$card->getBillingCountry();
            $billingDetails['zip'] = (string)$card->getBillingPostcode();
            $billingDetails['phone'] = (string)$card->getBillingPhone();

            // Netbanx does not allow blank strings in address.
            $billingDetails = array_filter($billingDetails);

            $shippingDetails = array();
            $shippingDetails['recipientName'] = (string)$card->getShippingName();
            $shippingDetails['street'] = (string)$card->getShippingAddress1();
            $shippingDetails['street2'] = (string)$card->getShippingAddress2();
            $shippingDetails['city'] = (string)$card->getShippingCity();
            $shippingDetails['state'] = (string)$card->getShippingState();
            $shippingDetails['country'] = (string)$card->getShippingCountry();
            $shippingDetails['zip'] = (string)$card->getShippingPostcode();
            $shippingDetails['phone'] = (string)$card->getShippingPhone();

            // Netbanx does not allow blank strings in address.
            $shippingDetails = array_filter($shippingDetails);

            $email = $card->getEmail();
            $emailNotEditable = array('key' => 'emailNotEditable', 'value' => true);
        }

        $data = $this->getBaseData();

        // Country and Zip required fields
        // https://developer.optimalpayments.com/en/documentation/hosted-payment-api/billingdetails-object/
        if (isset($billingDetails) && $billingDetails['country'] && $billingDetails['zip']) {
            $data['billingDetails'] = $billingDetails;
        }

        // Country and Zip required fields
        // https://developer.optimalpayments.com/en/documentation/hosted-payment-api/shippingdetails-object/
        if (isset($shippingDetails) && $shippingDetails['country'] && $shippingDetails['zip']) {
            $data['shippingDetails'] = $shippingDetails;
        }

        // Required Fields
        $data['totalAmount'] = $this->getAmountInteger();
        $data['currencyCode'] = $this->getCurrency();
        $data['merchantRefNum'] = $this->getTransactionId();

        $data['link'] = array($cancelUrl);
        $data['redirect'] = array($returnUrl, $errorUrl, $declineUrl);
        $data['customerNotificationEmail'] = $email;

        // Default extendedOptions
        // https://developer.optimalpayments.com/en/documentation/hosted-payment-api/extendedoptions-object/
        $data['extendedOptions'] = array();
        $data['extendedOptions'][] = $emailNotEditable;

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return HostedPurchaseResponse
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($this->getEndpointAction(), $data, 'POST');
        $responseData = json_decode($httpResponse->getBody(true), true);

        return $this->response = new HostedPurchaseResponse($this, $responseData);
    }

    /**
     * @return string
     */
    public function getEndpointAction()
    {
        return '/orders';
    }
}
