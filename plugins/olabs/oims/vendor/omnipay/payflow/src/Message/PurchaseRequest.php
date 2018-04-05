<?php

namespace Omnipay\Payflow\Message;

/**
 * Payflow Purchase Request
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
 */
class PurchaseRequest extends AuthorizeRequest
{
    protected $action = 'S';
}
