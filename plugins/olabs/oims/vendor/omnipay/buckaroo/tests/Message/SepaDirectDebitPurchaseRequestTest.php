<?php

namespace Omnipay\Buckaroo\Message;

use Omnipay\Tests\TestCase;

class SepaDirectDebitPurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new SepaDirectDebitPurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'websiteKey' => 'web',
                'secretKey' => 'secret',
                'amount' => '12.00',
                'returnUrl' => 'https://www.example.com/return',
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('sepadirectdebit', $data['Brq_payment_method']);
    }
}
