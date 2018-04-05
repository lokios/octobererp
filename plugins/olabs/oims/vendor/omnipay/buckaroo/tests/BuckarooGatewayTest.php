<?php

namespace Omnipay\Buckaroo;

use Omnipay\Tests\GatewayTestCase;

class BuckarooGatewayTest extends GatewayTestCase
{
    /**
     * @var BuckarooGateway
     */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new BuckarooGateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Buckaroo\Message\PurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }
}
