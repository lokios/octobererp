<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay SecureXML Echo Request.
 *
 * Echo requests are used to verify that the SecurePay payment server is
 * available.
 *
 * The status code returned in the response will be '000' if the service is up.
 */
class SecureXMLEchoTestRequest extends SecureXMLAbstractRequest
{
    protected $requestType = 'Echo';

    public function getData()
    {
        return $this->getBaseXML();
    }
}
