<?php

namespace Omnipay\Payflow\Message;

/**
 * Payflow Capture Request
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
 *
 * // Capture the authorization
 * $transaction = $gateway->capture(array(
 *     'amount'                   => '10.00',
 *     'transactionReference'     => $sale_id,
 * ));
 * $response = $transaction->send();
 * if ($response->isSuccessful()) {
 *     echo "Capture transaction was successful!\n";
 *     $sale_id = $response->getTransactionReference();
 *     echo "Transaction reference = " . $sale_id . "\n";
 * }
 * </code>
 */
class CaptureRequest extends AuthorizeRequest
{
    protected $action = 'D';

    public function getData()
    {
        $this->validate('transactionReference', 'amount');

        $data = $this->getBaseData();
        $data['AMT'] = $this->getAmount();
        $data['ORIGID'] = $this->getTransactionReference();

        return $data;
    }
}
