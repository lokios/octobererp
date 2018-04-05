<?php

namespace Omnipay\SecurePay\Message;

/**
 * SecurePay SecureXML Capture Request.
 *
 * Capture a partial or full amount that has been held by a prior authorize
 * request.
 *
 * The transactionId (purchaseOrderNo) and preauthID must match the prior
 * authorize transaction for the capture to succeed.
 */
class SecureXMLCaptureRequest extends SecureXMLAbstractRequest
{
    protected $txnType = 11; // Preauthorise Complete, as per Appendix A of documentation.
    protected $requiredFields = array('amount', 'transactionId', 'preauthId');

    public function getData()
    {
        $xml = $this->getBasePaymentXML();

        $xml->Payment->TxnList->Txn->addChild('preauthID', $this->getPreauthId());

        return $xml;
    }

    /**
     * Set the preauthId that was returned as part of the original authorize
     * request.
     */
    public function setPreauthId($value)
    {
        return $this->setParameter('preauthId', $value);
    }

    /**
     * @return string The preauthId from the authorize request that this
     *                capture matches.
     */
    public function getPreauthId()
    {
        return $this->getParameter('preauthId');
    }
}
