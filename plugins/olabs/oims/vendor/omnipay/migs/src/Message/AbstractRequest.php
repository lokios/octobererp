<?php

namespace Omnipay\Migs\Message;

/**
 * GoCardless Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'https://migs.mastercard.com.au/';
    protected $endpointTEST = 'https://migs-mtf.mastercard.com.au/';

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getMerchantAccessCode()
    {
        return $this->getParameter('merchantAccessCode');
    }

    public function setMerchantAccessCode($value)
    {
        return $this->setParameter('merchantAccessCode', $value);
    }

    public function getSecureHash()
    {
        return $this->getParameter('secureHash');
    }

    public function setSecureHash($value)
    {
        return $this->setParameter('secureHash', $value);
    }

    protected function getBaseData()
    {
        $data = array();
        $data['vpc_Merchant']   = $this->getMerchantId();
        $data['vpc_AccessCode'] = $this->getMerchantAccessCode();
        $data['vpc_Version']    = '1';
        $data['vpc_Locale']     = 'en';
        $data['vpc_Command']    = $this->action;
        $data['vpc_Amount']      = $this->getAmountInteger();
        $data['vpc_MerchTxnRef'] = $this->getTransactionId();
        $data['vpc_OrderInfo']   = $this->getDescription();
        $data['vpc_ReturnURL']   = $this->getReturnUrl();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function calculateHash($data)
    {
        ksort($data);

        $hash = null;
        foreach ($data as $k => $v) {
            // Skip vpc_ keys that are not included in the hash calculation
            if (in_array($k, array('vpc_SecureHash', 'vpc_SecureHashType'))) {
                continue;
            }

            if ((strlen($v) > 0) && ((substr($k, 0, 4)=="vpc_") || (substr($k, 0, 5) =="user_"))) {
                $hash .= $k . "=" . $v . "&";
            }
        }
        $hash = rtrim($hash, "&");

        return strtoupper(hash_hmac('SHA256', $hash, pack('H*', $this->getSecureHash())));
    }
}
