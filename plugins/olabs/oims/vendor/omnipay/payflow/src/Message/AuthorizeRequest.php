<?php

namespace Omnipay\Payflow\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Payflow Authorize Request
 *
 * ### Example
 *
 * <code>
 * // Create a gateway for the Payflow pro Gateway
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Payflow_Pro');
 *
 * // Initialise the gateway
 * $gateway->initialize(array(
 *     'username'       => $myusername,
 *     'password'       => $mypassword,
 *     'vendor'         => $mymerchantid,
 *     'partner'        => $PayPalPartner,
 *     'testMode'       => true, // Or false for live transactions.
 * ));
 *
 * // Create a credit card object
 * // This card can be used for testing.
 * $card = new CreditCard(array(
 *             'firstName'    => 'Example',
 *             'lastName'     => 'Customer',
 *             'number'       => '4242424242424242',
 *             'expiryMonth'  => '01',
 *             'expiryYear'   => '2020',
 *             'cvv'          => '123',
 * ));
 *
 * // Do an authorize transaction on the gateway
 * $transaction = $gateway->authorize(array(
 *     'amount'                   => '10.00',
 *     'currency'                 => 'AUD',
 *     'card'                     => $card,
 * ));
 * $response = $transaction->send();
 * if ($response->isSuccessful()) {
 *     echo "Authorize transaction was successful!\n";
 *     $sale_id = $response->getTransactionReference();
 *     echo "Transaction reference = " . $sale_id . "\n";
 * }
 * </code>
 */
class AuthorizeRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://payflowpro.paypal.com';
    protected $testEndpoint = 'https://pilot-payflowpro.paypal.com';
    protected $action = 'A';

    /**
     * Get the username.
     *
     * This is the ID that you specified when you got the Payflow account.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set the username.
     *
     * This is the ID that you specified when you got the Payflow account.
     *
     * @param string $value
     * @return AuthorizeRequest provides a fluent interface.
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Get the password.
     *
     * This is the password that you specified when you got the Payflow account.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set the password.
     *
     * This is the password that you specified when you got the Payflow account.
     *
     * @param string $value
     * @return AuthorizeRequest provides a fluent interface.
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Get the vendor.
     *
     * The ID that you specified when you got the Payflow account, the same as the username unless you
     * have created additional users on the account. That is, the merchant login ID for the account.
     *
     * @return string
     */
    public function getVendor()
    {
        return $this->getParameter('vendor');
    }

    /**
     * Set the vendor.
     *
     * The ID that you specified when you got the Payflow account, the same as the username unless you
     * have created additional users on the account. That is, the merchant login ID for the account.
     *
     * @param string $value
     * @return AuthorizeRequest provides a fluent interface.
     */
    public function setVendor($value)
    {
        return $this->setParameter('vendor', $value);
    }

    /**
     * Get the partner.
     *
     * The Payflow partner. This may be PayPal, or if an account was provided by an authorized PayPal
     * reseller, who registered a Payflow user, then the ID provided by the reseller is used.
     *
     * @return string
     */
    public function getPartner()
    {
        return $this->getParameter('partner');
    }

    /**
     * Set the partner.
     *
     * The Payflow partner. This may be PayPal, or if an account was provided by an authorized PayPal
     * reseller, who registered a Payflow user, then the ID provided by the reseller is used.
     *
     * @param string $value
     * @return AuthorizeRequest provides a fluent interface.
     */
    public function setPartner($value)
    {
        return $this->setParameter('partner', $value);
    }

    public function getComment1()
    {
        return $this->getDescription();
    }

    public function setComment1($value)
    {
        return $this->setDescription($value);
    }

    public function getComment2()
    {
        return $this->getParameter('comment2');
    }

    public function setComment2($value)
    {
        return $this->setParameter('comment2', $value);
    }

    /**
     * @deprecated
     */
    public function getOrigid()
    {
        return $this->getParameter('origid');
    }

    /**
     * @deprecated
     */
    public function setOrigid($value)
    {
        return $this->setParameter('origid', $value);
    }

    protected function getBaseData()
    {
        $data = array();
        $data['TRXTYPE'] = $this->action;
        $data['USER'] = $this->getUsername();
        $data['PWD'] = $this->getPassword();
        $data['VENDOR'] = $this->getVendor();
        $data['PARTNER'] = $this->getPartner();

        return $data;
    }

    public function getData()
    {
        $this->validate('amount');
        $data = $this->getBaseData();

        if ($this->getCardReference()) {
            $data['ORIGID'] = $this->getCardReference();
        } else {
            $this->validate('card');
            $this->getCard()->validate();

            $data['ACCT'] = $this->getCard()->getNumber();
            $data['EXPDATE'] = $this->getCard()->getExpiryDate('my');
            $data['CVV2'] = $this->getCard()->getCvv();
            $data['BILLTOFIRSTNAME'] = $this->getCard()->getFirstName();
            $data['BILLTOLASTNAME'] = $this->getCard()->getLastName();
            $data['BILLTOSTREET'] = $this->getCard()->getAddress1();
            $data['BILLTOCITY'] = $this->getCard()->getCity();
            $data['BILLTOSTATE'] = $this->getCard()->getState();
            $data['BILLTOZIP'] = $this->getCard()->getPostcode();
            $data['BILLTOCOUNTRY'] = $this->getCard()->getCountry();
        }

        $data['TENDER'] = 'C';
        $data['AMT'] = $this->getAmount();
        $data['CURRENCY'] = $this->getCurrency();
        $data['COMMENT1'] = $this->getDescription();
        $data['COMMENT2'] = $this->getComment2();
        $data['ORDERID'] = $this->getTransactionId();

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post(
            $this->getEndpoint(),
            null,
            $this->encodeData($data)
        )->send();

        return $this->response = new Response($this, $httpResponse->getBody());
    }

    /**
     * Encode absurd name value pair format
     */
    public function encodeData(array $data)
    {
        $output = array();
        foreach ($data as $key => $value) {
            $output[] = $key.'['.strlen($value).']='.$value;
        }

        return implode('&', $output);
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
