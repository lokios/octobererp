<?php

namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{

    public function testConstruct()
    {
        $response = new Purchaseresponse(
            $this->getMockRequest(),
            array(
            'sid' => '1441',
            'mode' => '2CO',
            'sandbox' => false
            )
        );

        $this->assertSame('https://www.2checkout.com/checkout/purchase', $response->getEndPoint());
        $this->assertSame('https://www.2checkout.com/checkout/purchase?sid=1441&mode=2CO', $response->getRedirectUrl());
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
    }
}
