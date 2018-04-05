<?php

namespace Omnipay\Buckaroo\Message;

use Omnipay\Tests\TestCase;

class CreditCardPurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new CreditCardPurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
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
        $this->request->initialize(array(
            'websiteKey' => 'web',
            'secretKey' => 'secret',
            'amount' => '12.00',
            'currency' => 'EUR',
            'testMode' => true,
            'transactionId' => 13,
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
            'culture' => 'nl-NL',
            'paymentMethod' => 'mastercard'
        ));

        $data = $this->request->getData();

        $this->assertSame('web', $data['Brq_websitekey']);
        $this->assertSame('12.00', $data['Brq_amount']);
        $this->assertSame('EUR', $data['Brq_currency']);
        $this->assertSame(13, $data['Brq_invoicenumber']);
        $this->assertSame('https://www.example.com/return', $data['Brq_return']);
        $this->assertSame('https://www.example.com/cancel', $data['Brq_returncancel']);
        $this->assertSame('nl-NL', $data['Brq_culture']);
        $this->assertSame('mastercard', $data['Brq_payment_method']);
    }
    public function testGetDataPaymentMethodFallback()
    {
        $this->request->initialize(array(
            'websiteKey' => 'web',
            'secretKey' => 'secret',
            'amount' => '12.00',
            'currency' => 'EUR',
            'testMode' => true,
            'transactionId' => 13,
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
            'culture' => 'nl-NL',
        ));

        $data = $this->request->getData();

        $this->assertSame('web', $data['Brq_websitekey']);
        $this->assertSame('12.00', $data['Brq_amount']);
        $this->assertSame('EUR', $data['Brq_currency']);
        $this->assertSame(13, $data['Brq_invoicenumber']);
        $this->assertSame('https://www.example.com/return', $data['Brq_return']);
        $this->assertSame('https://www.example.com/cancel', $data['Brq_returncancel']);
        $this->assertSame('nl-NL', $data['Brq_culture']);
        $this->assertSame('visa,mastercard,amex', $data['Brq_requestedservices']);
    }
}
