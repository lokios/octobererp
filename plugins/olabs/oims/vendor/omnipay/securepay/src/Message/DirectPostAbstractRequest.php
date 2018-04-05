<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay Direct Post Abstract Request
 */
abstract class DirectPostAbstractRequest extends AbstractRequest
{
    public $testEndpoint = 'https://api.securepay.com.au/test/directpost/authorise';
    public $liveEndpoint = 'https://api.securepay.com.au/live/directpost/authorise';
}
