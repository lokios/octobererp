<?php

namespace Omnipay\NetBanx;

use Omnipay\Common\CreditCard;
use Omnipay\NetBanx\Message\HostedPurchaseResponse;
use Omnipay\Tests\GatewayTestCase;

class HostedGatewayTest extends GatewayTestCase
{
    protected $purchaseOptions;

    public function setUp()
    {
        parent::setUp();
        $this->gateway = new HostedGateway($this->getHttpClient(), $this->getHttpRequest());

        $card = new CreditCard($this->getValidCard());

        $card->setBillingAddress1('Wall street');
        $card->setBillingAddress2('Wall street 2');
        $card->setBillingCity('San Luis Obispo');
        $card->setBillingCountry('US');
        $card->setBillingPostcode('93401');
        $card->setBillingPhone('1234567');
        $card->setBillingState('CA');

        $card->setShippingAddress1('Shipping Wall street');
        $card->setShippingAddress2('Shipping Wall street 2');
        $card->setShippingCity('San Luis Obispo');
        $card->setShippingCountry('US');
        $card->setShippingPostcode('93401');
        $card->setShippingPhone('1234567');
        $card->setShippingState('CA');

        $card->setCompany('Test Business name');
        $card->setEmail('test@example.com');

        $this->purchaseOptions = array(
            'amount'    => '95.63',
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
            'currency'  => 'GBP'
        );

        $this->completePurchaseOptions = array(
            'transactionReference' => '284BRTAQFS63EOA1LD'
        );
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('HostedPurchaseSuccess.txt');

        $request = $this->gateway->purchase($this->purchaseOptions);

        $requestData = $request->getData();
        /** @var HostedPurchaseResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Omnipay\NetBanx\Message\HostedPurchaseRequest', $request);

        // Test Request
        $this->assertSame(9563, $requestData['totalAmount']);
        $this->assertSame('GBP', $requestData['currencyCode']);

        // Test response
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertFalse($response->isPending());
        $this->assertSame('284BRTAQFS63EOA1LD', $response->getTransactionReference());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('https://pay.test.netbanx.com/hosted/v1/payment/53616c7465645f5f620e8e8fed4517d964208355a0b5dfb087d38e77f05aa00d9dbb3e7f9f379cb8',
            $response->getRedirectUrl());
    }

    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('HostedPurchaseFailure.txt');

        $request = $this->gateway->purchase($this->purchaseOptions);

        $requestData = $request->getData();
        /** @var HostedPurchaseResponse $response */
        $response = $request->send();

        // Test Request
        $this->assertSame(9563, $requestData['totalAmount']);
        $this->assertSame('GBP', $requestData['currencyCode']);

        // Test response
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('400', $response->getCode());
        $this->assertSame('Duplicate merchant reference', $response->getMessage());
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('HostedPurchaseSuccess.txt');

        $request = $this->gateway->authorize($this->purchaseOptions);
        $this->assertInstanceOf('\Omnipay\NetBanx\Message\HostedAuthorizeRequest', $request);

        $requestData = $request->getData();
        /** @var HostedPurchaseResponse $response */
        $response = $request->send();

        $extendedOptions = array(
            array('key' => 'emailNotEditable', 'value' => true),
            array('key' => 'authType', 'value' => 'auth')
        );

        // Test Request
        $this->assertSame($extendedOptions, $requestData['extendedOptions']);
        $this->assertSame(9563, $requestData['totalAmount']);
        $this->assertSame('GBP', $requestData['currencyCode']);

        // Test response
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertFalse($response->isPending());
        $this->assertSame('284BRTAQFS63EOA1LD', $response->getTransactionReference());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('https://pay.test.netbanx.com/hosted/v1/payment/53616c7465645f5f620e8e8fed4517d964208355a0b5dfb087d38e77f05aa00d9dbb3e7f9f379cb8',
            $response->getRedirectUrl());
    }

    public function testAuthorizeFailure()
    {
        $this->setMockHttpResponse('HostedPurchaseFailure.txt');

        $request = $this->gateway->purchase($this->purchaseOptions);

        $requestData = $request->getData();
        /** @var HostedPurchaseResponse $response */
        $response = $request->send();

        // Test Request
        $this->assertSame(9563, $requestData['totalAmount']);
        $this->assertSame('GBP', $requestData['currencyCode']);

        // Test response
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('400', $response->getCode());
    }

    public function testCompletePurchaseSuccess()
    {
        $this->setMockHttpResponse('HostedCompletePurchaseSuccess.txt');

        $request = $this->gateway->completePurchase($this->completePurchaseOptions);
        $this->assertInstanceOf('\Omnipay\NetBanx\Message\HostedCompletePurchaseRequest', $request);

        /** @var \Omnipay\NetBanx\Message\HostedCompletePurchaseRequest $request */
        $requestData = $request->getData();

        $this->assertSame('284BRTAQFS63EOA1LD', $requestData['transactionReference']);

        // Test response

        /** @var \Omnipay\NetBanx\Message\HostedPurchaseResponse $response */
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertFalse($response->isPending());
        $this->assertSame('284BRTAQFS63EOA1LD', $response->getTransactionReference());
        $this->assertNull($response->getCode());
        $this->assertSame('361928800', $response->getMessage());
    }

    public function testCompleteAuthorizeSuccess()
    {
        $this->setMockHttpResponse('HostedCompleteAuthorizeSuccess.txt');

        $request = $this->gateway->completePurchase($this->completePurchaseOptions);
        $this->assertInstanceOf('\Omnipay\NetBanx\Message\HostedCompletePurchaseRequest', $request);

        /** @var \Omnipay\NetBanx\Message\HostedCompletePurchaseRequest $request */
        $requestData = $request->getData();

        $this->assertSame('284BRTAQFS63EOA1LD', $requestData['transactionReference']);

        // Test response

        /** @var \Omnipay\NetBanx\Message\HostedPurchaseResponse $response */
        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertFalse($response->isPending());
        $this->assertSame('284BRTAQFS63EOA1LD', $response->getTransactionReference());
        $this->assertNull($response->getCode());
        $this->assertSame('361928800', $response->getMessage());
    }
}