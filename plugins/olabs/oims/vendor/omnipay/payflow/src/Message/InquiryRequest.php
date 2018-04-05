<?php

namespace Omnipay\Payflow\Message;

/**
 * Payflow Inquiry Request
 *
 * @deprecated
 */
class InquiryRequest extends AuthorizeRequest
{
    protected $action = 'I';

    public function getData()
    {
        $data = $this->getBaseData();

        $data['TENDER'] = 'C';
        $data['VERBOSITY'] = 'HIGH';
        $data['ORIGID'] = $this->getOrigid();

        return $data;
    }
}
