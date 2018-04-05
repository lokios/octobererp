<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay SecureXML Authorize Request.
 *
 * Verify that the amount is available and hold for capture.
 *
 * Returns a 'preauthID' value that must be supplied in any subsequent capture
 * request.
 */
class SecureXMLAuthorizeRequest extends SecureXMLAbstractRequest
{
    protected $txnType = 10; // Preauthorise, as per Appendix A of documentation.
    protected $requiredFields = array('amount', 'card', 'transactionId');

    public function getData()
    {
        return $this->getBasePaymentXMLWithCard();
    }
}
