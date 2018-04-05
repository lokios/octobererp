<?php

namespace Omnipay\Payflow\Message;

/**
 * Payflow Create Credit Card Request
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
 * // Do a create card transaction on the gateway
 * $transaction = $gateway->createCard(array(
 *     'card'                     => $card,
 * ));
 * $response = $transaction->send();
 * if ($response->isSuccessful()) {
 *     echo "Create Card transaction was successful!\n";
 *     $card_id = $response->getCardReference();
 *     echo "Card reference = " . $card_id . "\n";
 * }
 * </code>
 */
class CreateCardRequest extends AuthorizeRequest
{
    protected $action = 'L';

    public function getData()
    {

        $this->getCard()->validate();
        $data = $this->getBaseData();

        $data['TENDER'] = 'C';

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

        return $data;
    }
}
