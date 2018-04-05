<?php

namespace Omnipay\Payflow;

use Omnipay\Common\AbstractGateway;

/**
 * Payflow Pro Class
 *
 * Payflow refers to a suite of products. This gateway implements an interface to the PayFlow
 * Pro gateway as described here:
 *
 * https://developer.paypal.com/docs/classic/products/payflow-gateway/
 *
 * Note that there are 3 other gateways mentioned in the above documentation, these are:
 *
 * * PayPal Payments Pro, implemented by the omnipay-paypal gateway plugin.
 * * PayPal Payments Advanced, deprecated.
 * * PayFlow Link, deprecated.
 *
 * Although PayPal Payments Advanced and PayFlow Link are supported for existing clients,
 * there is no omnipay implementation of either.
 *
 * Note that the PayPal Payments Pro gateway internally uses the Payflow gateway and
 * provides much the same functionality.
 *
 * ### Availability
 *
 * * USA
 * * Canada
 * * UK
 * * Australia
 *
 * For registration instructions for each country see here:
 *
 * https://developer.paypal.com/docs/classic/products/payflow-gateway/
 *
 * ### Authentication
 *
 * Authentication requires the following parameters which are supplied at the time of gateway
 * initialisation:
 *
 * * username
 * * password
 * * partner.  This is the Payflow partner. The example below uses PayPal, since in this document,
 *   the account was purchased directly from PayPal. If an account was provided by an authorized
 *   PayPal reseller, who registered a Payflow user,then the ID provided by the reseller is used.
 * * vendor.  This is the merchant login ID for the account.  This will often be the same as the
 *   username.
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
 * // Do a purchase transaction on the gateway
 * $transaction = $gateway->purchase(array(
 *     'amount'                   => '10.00',
 *     'currency'                 => 'AUD',
 *     'card'                     => $card,
 * ));
 * $response = $transaction->send();
 * if ($response->isSuccessful()) {
 *     echo "Purchase transaction was successful!\n";
 *     $sale_id = $response->getTransactionReference();
 *     echo "Transaction reference = " . $sale_id . "\n";
 * }
 * </code>
 *
 * @link https://developer.paypal.com/docs/classic/products/payflow-gateway/
 */
class ProGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Payflow';
    }

    public function getDefaultParameters()
    {
        return array(
            'username' => '',
            'password' => '',
            'vendor' => '',
            'partner' => '',
            'testMode' => false,
        );
    }

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
     * @return ProGateway provides a fluent interface.
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
     * @return ProGateway provides a fluent interface.
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
     * @return ProGateway provides a fluent interface.
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
     * @return ProGateway provides a fluent interface.
     */
    public function setPartner($value)
    {
        return $this->setParameter('partner', $value);
    }

    /**
     * Create an authorize request.
     *
     * @param array $parameters
     * @return \Omnipay\Payflow\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payflow\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Create a capture request.
     *
     * @param array $parameters
     * @return \Omnipay\Payflow\Message\CaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payflow\Message\CaptureRequest', $parameters);
    }

    /**
     * Create a purchase request.
     *
     * @param array $parameters
     * @return \Omnipay\Payflow\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payflow\Message\PurchaseRequest', $parameters);
    }

    /**
     * Create a refund request.
     *
     * @param array $parameters
     * @return \Omnipay\Payflow\Message\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payflow\Message\RefundRequest', $parameters);
    }

    /**
     * Create a void request.
     *
     * @param array $parameters
     * @return \Omnipay\Payflow\Message\VoidRequest
     */
    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payflow\Message\VoidRequest', $parameters);
    }

    /**
     * Create a create card request.
     *
     * @param array $parameters
     * @return \Omnipay\Payflow\Message\CreateCardRequest
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payflow\Message\CreateCardRequest', $parameters);
    }

    /**
     * Create an inquiry request.
     *
     * @deprecated use fetchTransaction instead
     */
    public function inquiry(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payflow\Message\InquiryRequest', $parameters);
    }

    /**
     * Create a fetch transaction request.
     *
     * @param array $parameters
     * @return \Omnipay\Payflow\Message\FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payflow\Message\FetchTransactionRequest', $parameters);
    }
}
