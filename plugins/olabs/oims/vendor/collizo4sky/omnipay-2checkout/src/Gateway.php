<?php

namespace Omnipay\TwoCheckoutPlus;

use Omnipay\Common\AbstractGateway;

/**
 * 2Checkout Gateway.
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'TwoCheckoutPlus';
    }

    public function getDefaultParameters()
    {
        return array(
            'accountNumber' => '',
            'secretWord' => '',
            // if true, transaction with the live checkout URL will be a demo sale and card won't be charged.
            'demoMode' => false,
            'testMode' => false,
        );
    }

    /**
     * Getter: get cart items.
     *
     * @return array
     */
    public function getCart()
    {
        return $this->getParameter('cart');
    }

    /**
     * Array of cart items.
     *
     * format:
     * $gateway->setCart(array(
     * array(
     * 'type'        => 'product',
     * 'name'        => 'Product 1',
     * 'description' => 'Description of product 1',
     * 'quantity'    => 2,
     * 'price'       => 22,
     * 'tangible'    => 'N',
     * 'product_id'  => 12345,
     * 'recurrence'  => '1 Week',
     * 'duration'    => '1 Year',
     * 'startup_fee' => '5',
     * ),
     * array(
     * 'type'     => 'product',
     * 'name'     => 'Product 2',
     * 'quantity' => 1,
     * 'price'    => 10,
     * 'tangible' => 'N'
     * 'product_id'  => 45678,
     * 'recurrence'  => '2 Week',
     * 'duration'    => '1 Year',
     * 'startup_fee' => '3',
     * )
     * ));
     *
     * @param array $value
     *
     * @return $this
     */
    public function setCart($value)
    {
        return $this->setParameter('cart', $value);
    }

    /**
     * Getter: demo mode.
     *
     * @return string
     */
    public function getDemoMode()
    {
        return $this->getParameter('demoMode');
    }

    /**
     * Setter: demo mode.
     *
     * @param $value
     *
     * @return $this
     */
    public function setDemoMode($value)
    {
        return $this->setParameter('demoMode', $value);
    }

    /**
     * Getter: checkout language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * Setter: checkout language.
     *
     * @param $value
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * Getter: coupon.
     *
     * @return string
     */
    public function getCoupon()
    {
        return $this->getParameter('coupon');
    }

    /**
     * Setter: coupon.
     *
     * @param $value
     *
     * @return $this
     */
    public function setCoupon($value)
    {
        return $this->setParameter('coupon', $value);
    }

    /**
     * Getter: 2Checkout account number.
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    /**
     * Setter: 2Checkout account number.
     *
     * @param $value
     *
     * @return $this
     */
    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }

    /**
     * Getter: 2Checkout secret word.
     *
     * @return string
     */
    public function getSecretWord()
    {
        return $this->getParameter('secretWord');
    }

    /**
     * Setter: 2Checkout secret word.
     *
     * @param $value
     *
     * @return $this
     */
    public function setSecretWord($value)
    {
        return $this->setParameter('secretWord', $value);
    }

    /**
     * @return Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\TwoCheckoutPlus\Message\PurchaseRequest', $parameters);
    }

    /**
     * @return Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\TwoCheckoutPlus\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @return Message\NotificationRequest
     */
    public function acceptNotification(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\TwoCheckoutPlus\Message\NotificationRequest', $parameters);
    }
}
