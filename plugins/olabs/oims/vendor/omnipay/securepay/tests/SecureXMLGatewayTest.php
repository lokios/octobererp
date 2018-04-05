<?php

namespace Omnipay\SecurePay;

use Omnipay\Tests\GatewayTestCase;

class SecureXMLGatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new SecureXMLGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setMerchantId('ABC0001');
    }

    public function testAuthorize()
    {
        $request = $this->gateway->authorize(array('amount' => '10.00'));

        $this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLAuthorizeRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLPurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testRefund()
    {
        $request = $this->gateway->refund(array('amount' => '10.00', 'transactionId' => 'order12345'));

        $this->assertInstanceOf('\Omnipay\SecurePay\Message\SecureXMLRefundRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('order12345', $request->getTransactionId());
    }
}
