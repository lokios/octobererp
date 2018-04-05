<?php

namespace Omnipay\TwoCheckoutPlus;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public $gateway;
    public $options;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->gateway->setAccountNumber('901290261');
        $this->gateway->setSecretWord('MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj');
        $this->gateway->setTestMode(true);
        $this->gateway->setDemoMode(true);
        $this->gateway->setLanguage('fr');
        $this->gateway->setCoupon('BlackFriday');
        $this->gateway->setCart(array(
            array(
                'type'        => 'product',
                'name'        => 'Product 1',
                'description' => 'Description of product 1',
                'quantity'    => 2,
                'price'       => 22,
                'tangible'    => 'N',
                'product_id'  => 12345,
                'recurrence'  => '1 Week',
                'duration'    => '1 Year',
                'startup_fee' => '5',
            ),
            array(
                'type'     => 'product',
                'name'     => 'Product 2',
                'quantity' => 1,
                'price'    => 10,
                'tangible' => 'N'
            )
        ));

        $this->options = array(
            'card'          => $this->getValidCard(),
            'transactionId' => 1234,
            'currency'      => 'USD',
            'returnUrl'     => 'http://localhost/omnipay-2checkout/complete.php'
        );
    }

    public function testGateway()
    {
        $cart = $this->gateway->getCart();
        $this->assertSame('901290261', $this->gateway->getAccountNumber());
        $this->assertSame('MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj', $this->gateway->getSecretWord());
        $this->assertSame('BlackFriday', $this->gateway->getCoupon());
        $this->assertSame('fr', $this->gateway->getLanguage());
        $this->assertTrue($this->gateway->getTestMode());
        $this->assertTrue($this->gateway->getDemoMode());
        $this->assertSame('product', $cart[0]['type']);
        $this->assertSame('Product 1', $cart[0]['name']);
        $this->assertSame(2, $cart[0]['quantity']);
        $this->assertSame(22, $cart[0]['price']);
        $this->assertSame('N', $cart[0]['tangible']);
        $this->assertSame(12345, $cart[0]['product_id']);
    }


    public function testPurchase()
    {
        $request = $this->gateway->purchase($this->options)->send();

        $this->assertSame(false, $request->isSuccessful());
        $this->assertSame(true, $request->isRedirect());
        $this->assertSame('GET', $request->getRedirectMethod());
        $this->assertSame('https://sandbox.2checkout.com/checkout/purchase', $request->getEndPoint());
        $this->assertNull($request->getRedirectData());
    }


    public function testCompletePurchaseWithGETParameters()
    {
        // mock / set a test MD5 hash, total order amount and order number
        $this->getHttpRequest()->initialize(
            array(
                'order_number'      => 1234,
                'merchant_order_id' => 56789,
                'total'             => 20,
                'key'               => $this->gateway->getTestMode() ? '21937BDC2F33AF28503800677DE7C4F8' : '686C451E66D5766DEC3A1E74379C7BAD',
            )
        );

        $request = $this->gateway->completePurchase($this->options)->send();
        $this->assertSame(true, $request->isSuccessful());
        $this->assertSame(1234, $request->getTransactionReference());
        $this->assertSame(56789, $request->getTransactionId());
    }

    public function testCompletePurchaseWithPOSTParameters()
    {
        // mock / set a test MD5 hash, total order amount and order number
        $this->getHttpRequest()->initialize(
            array(),
            array(
                'order_number'      => 1234,
                'merchant_order_id' => 56789,
                'total'             => 20,
                'key'               => $this->gateway->getTestMode() ? '21937BDC2F33AF28503800677DE7C4F8' : '686C451E66D5766DEC3A1E74379C7BAD',
            )
        );

        $request = $this->gateway->completePurchase($this->options)->send();
        $this->assertSame(true, $request->isSuccessful());
        $this->assertSame(1234, $request->getTransactionReference());
        $this->assertSame(1234, $request->getTransactionReference());
    }

    /**
     * @expectedException Omnipay\Common\Exception\InvalidResponseException
     */
    public function testCompletePurchaseInvalidResponseException()
    {
        // mock / set a test MD5 hash, total order amount and order number
        $this->getHttpRequest()->initialize(
            array(
                'order_number' => 1234,
                'total'        => 20,
                'key'          => 'BadMD5harsh',
            )
        );

        $this->gateway->completePurchase($this->options)->send();
    }

    public function testAcceptNotificationFail() {

        $this->getHttpRequest()->initialize(
            array(),
            $this->getMockHttpResponse('FraudChangeNotificationFail.txt')->json()
        );

        $response = $this->gateway->acceptNotification()->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('4742525399', $response->getTransactionReference());
        $this->assertSame('FRAUD_STATUS_CHANGED', $response->getNotificationType());
        $this->assertSame(true, $response->getTransactionStatus());
    }
}
