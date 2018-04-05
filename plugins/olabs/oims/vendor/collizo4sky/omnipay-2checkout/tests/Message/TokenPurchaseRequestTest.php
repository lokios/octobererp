<?php
namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Tests\TestCase;

class TokenPurchaseRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $mock = new \Guzzle\Plugin\Mock\MockPlugin();
        $mock->addResponse($this->getMockHttpResponse('TokenPurchaseFailure.txt'));

        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mock);

        $this->request = new TokenPurchaseRequest($httpClient, $this->getHttpRequest());
        $this->request->initialize(array(
            'card'          => $this->getValidCard(),
            'token'         => 'Y2RkZDdjN2EtNjFmZS00ZGYzLWI4NmEtNGZhMjI3NmExMzQ0',
            'transactionId' => '123456',
            'currency'      => 'USD',
            'amount'        => '20.5'
        ));

        $this->request->setAccountNumber('801290261');
        $this->request->setTestMode(true);
        $this->request->setPrivateKey('5F876A36-D506-4E1F-8EE9-DA2358500F9C');
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('5F876A36-D506-4E1F-8EE9-DA2358500F9C', $data['privateKey']);
    }

    public function testSendData()
    {
        $data     = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\TwoCheckoutPlus\Message\TokenPurchaseResponse', get_class($response));
    }

}
