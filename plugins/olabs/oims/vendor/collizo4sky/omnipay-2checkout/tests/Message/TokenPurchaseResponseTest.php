<?php
namespace Omnipay\TwoCheckoutPlus\Message;

use Guzzle\Http\Message\Response;
use Omnipay\Tests\TestCase;

class TokenPurchaseResponseTest extends TestCase
{


    public function testSuccess()
    {
        $body         = file_get_contents(dirname(dirname(__FILE__)) . '/Mock/TokenPurchaseSuccess.txt');
        $httpResponse = new Response(200, array('Content-Type' => 'application/json'), $body);
        $response     = new TokenPurchaseResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('205182114555', $response->getTransactionReference());
    }

    public function testFailure()
    {
        $httpResponse = $this->getMockHttpResponse('TokenPurchaseFailure.txt');
        $response     = new TokenPurchaseResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('602', $response->getCode());
        $this->assertSame('Payment Authorization Failed:  Please verify your Credit Card details are entered correctly and try again, or try another payment method.',
            $response->getMessage());
        $this->assertNull($response->getTransactionReference());
    }
}