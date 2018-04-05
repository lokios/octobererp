<?php

namespace Omnipay\SecurePay\Message;

use Omnipay\Tests\TestCase;

class SecureXMLEchoTestRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new SecureXMLEchoTestRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize(
            array(
                'merchantId' => 'ABC0030',
                'transactionPassword' => 'abc123',
            )
        );
    }

    public function testSuccess()
    {
        $this->setMockHttpResponse('SecureXMLEchoTestRequestSuccess.txt');
        $response = $this->request->send();
        $data = $response->getData();

        $this->assertInstanceOf('Omnipay\\SecurePay\\Message\\SecureXMLResponse', $response);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('000', $response->getCode());
        $this->assertSame('Normal', $response->getMessage());
    }
}
