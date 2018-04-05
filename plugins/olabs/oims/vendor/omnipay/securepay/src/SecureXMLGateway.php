<?php

namespace Omnipay\SecurePay;

use Omnipay\Common\AbstractGateway;

/**
 * SecurePay Secure XML Gateway.
 *
 * Example:
 *
 * <code>
 *   // Initialise the test gateway
 *   $gateway = \Omnipay\Omnipay::create('SecurePay_SecureXML');
 *   $gateway->setMerchantId('ABC0001');
 *   $gateway->setTransactionPassword('abc123');
 *   $gateway->setTestMode(true);
 *
 *   // Create a credit card object
 *   $card = new \Omnipay\Common\CreditCard(
 *       [
 *           'number'      => '4444333322221111',
 *           'expiryMonth' => '6',
 *           'expiryYear'  => '2020',
 *           'cvv'         => '123',
 *       ]
 *   );
 *
 *   // Perform a purchase test
 *   $transaction = $gateway->purchase(
 *       [
 *           'amount'        => '10.00',
 *           'currency'      => 'AUD',
 *           'transactionId' => 'invoice_12345',
 *           'card'          => $card,
 *       ]
 *   );
 *
 *   $response = $transaction->send();
 *
 *   if ($response->isSuccessful()) {
 *       echo sprintf('Transaction %s was successful!', $response->getTransactionReference());
 *   } else {
 *       echo sprintf('Transaction %s failed: %s', $response->getTransactionReference(), $response->getMessage());
 *   }
 * </code>
 *
 * @link https://www.securepay.com.au/_uploads/files/Secure_XML_API_Integration_Guide.pdf
 */
class SecureXMLGateway extends AbstractGateway
{
    public function getName()
    {
        return 'SecurePay SecureXML';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'transactionPassword' => '',
            'testMode' => false,
        );
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getTransactionPassword()
    {
        return $this->getParameter('transactionPassword');
    }

    public function setTransactionPassword($value)
    {
        return $this->setParameter('transactionPassword', $value);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SecurePay\Message\SecureXMLAuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SecurePay\Message\SecureXMLCaptureRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SecurePay\Message\SecureXMLPurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SecurePay\Message\SecureXMLRefundRequest', $parameters);
    }

    public function echoTest(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SecurePay\Message\SecureXMLEchoTestRequest', $parameters);
    }
}
