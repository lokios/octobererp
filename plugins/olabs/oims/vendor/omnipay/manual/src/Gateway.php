<?php
/**
 * Manual Gateway
 */

namespace Omnipay\Manual;

use Omnipay\Common\AbstractGateway;

/**
 * Manual Gateway
 *
 * This gateway is useful for processing check or direct debit payments. It simply
 * authorizes every payment.
 *
 * ### Example
 *
 * #### Initialize Gateway
 *
 * ```php
 * // Create a gateway for the Manual Gateway
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Manual');
 *
 * // Initialise the gateway
 * $gateway->initialize(array(
 *     'testMode' => true, // Or false. Doesn't matter.
 * ));
 * ```
 *
 * #### Authorize
 *
 * <code>
 * // Do a purchase transaction on the gateway
 * try {
 *     $transaction = $gateway->authorize(array(
 *         'amount'        => '10.00',
 *         'currency'      => 'AUD',
 *         'description'   => 'This is a test transaction.',
 *       ));
 *     $response = $transaction->send();
 *     $data = $response->getData();
 *     echo "Gateway authorize response data == " . print_r($data, true) . "\n";
 *
 *     if ($response->isSuccessful()) {
 *         echo "Transaction was successful!\n";
 *     }
 * } catch (\Exception $e) {
 *     echo "Exception caught while attempting authorize.\n";
 *     echo "Exception type == " . get_class($e) . "\n";
 *     echo "Message == " . $e->getMessage() . "\n";
 * }
 * </code>
 *
 * In reality, Manual Gateway authorize() requests will always be successful and
 * will never throw an exception, but the above example shows that you can treat
 * manual payments just like any other payment type for any other gateway.
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Manual';
    }

    public function getDefaultParameters()
    {
        return array();
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Manual\Message\Request', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Manual\Message\Request', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Manual\Message\Request', $parameters);
    }

    public function completeAuthorise(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Manual\Message\Request', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Manual\Message\Request', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Manual\Message\Request', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Manual\Message\Request', $parameters);
    }
}
