<?php

namespace Omnipay\SecurePay\Message;

use Omnipay\Common\Message\AbstractResponse;

class SecureXMLResponse extends AbstractResponse
{
    /**
     * Determine if the transaction is successful or not.
     *
     * @note Rather than using HTTP status codes, the SecureXML API returns a
     * status code as part of the response if there is an internal API issue.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        // As per appendix F, 000 means the message was processed correctly
        if ((string) $this->data->Status->statusCode !== '000'
            || ($this->hasTransaction()
                && (string) $this->data->Payment->TxnList->Txn->approved !== 'Yes')) {
            return false;
        }

        return true;
    }

    /**
     * Determine if we have had payment information returned.
     *
     * @note For certain errors a Payment element is returned but has an empty
     * TxnList so this will tell us if we actually have a transaction to check.
     *
     * @return bool True if we have a transaction.
     */
    protected function hasTransaction()
    {
        return isset($this->data->Payment->TxnList->Txn);
    }

    /**
     * @link https://www.securepay.com.au/_uploads/files/SecurePay_Response_Codes.pdf
     *
     * @return string Gateway failure code or transaction code if available.
     */
    public function getCode()
    {
        return $this->hasTransaction()
            ? (string) $this->data->Payment->TxnList->Txn->responseCode
            : (string) $this->data->Status->statusCode;
    }

    /**
     * @return string Gateway failure message or transaction message if
     *                available.
     */
    public function getMessage()
    {
        return $this->hasTransaction()
            ? (string) $this->data->Payment->TxnList->Txn->responseText
            : (string) $this->data->Status->statusDescription;
    }

    /**
     * @return string Unique SecurePay bank transaction reference.
     */
    public function getTransactionReference()
    {
        return $this->hasTransaction()
            ? (string) $this->data->Payment->TxnList->Txn->txnID
            : null;
    }

    /**
     * @return string|null Settlement date when the funds will be settled into the
     *                     merchants account.
     */
    public function getSettlementDate()
    {
        return $this->hasTransaction()
            ? (string) $this->data->Payment->TxnList->Txn->settlementDate
            : null;
    }
}
