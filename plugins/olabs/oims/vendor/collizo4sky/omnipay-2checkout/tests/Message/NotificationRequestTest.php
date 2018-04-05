<?php
namespace Omnipay\TwoCheckoutPlus\Message;

use Omnipay\Tests\TestCase;

class NotificationRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $mockHttpRequest = $this->getMockBuilder('\Symfony\Component\HttpFoundation\Request')
                                ->setConstructorArgs(
                                    array(
                                        array(),
                                        // directly passing an array of the POSTed data would do but to prevent
                                        // duplicate array in test, i made it seem like an API response then
                                        // get the response as an array using json() method.
                                        $this->getMockHttpResponse('FraudChangeNotificationFail.txt')->json()
                                    )
                                )
                                ->setMethods(null)
                                ->getMock();

        $this->request = new NotificationRequest($this->getHttpClient(), $mockHttpRequest);
        $this->request->setAccountNumber('901290261');
        $this->request->setSecretWord('MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj');
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('2012-07-26', $data['auth_exp']);
        $this->assertSame('FRAUD_STATUS_CHANGED', $data['message_type']);
        $this->assertSame('MzBjODg5YTUtNzcwMS00N2NlLWFkODMtNzQ2YzllZWRjMzBj', $data['secretWord']);
        $this->assertSame('901290261', $data['accountNumber']);
    }


    public function testSendData()
    {
        $data     = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\TwoCheckoutPlus\Message\NotificationResponse', get_class($response));
    }

}