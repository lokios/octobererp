<?php

namespace Omnipay\NetBanx\Message;

class HostedAuthorizeRequest extends HostedPurchaseRequest
{

    /**
     * @return array|mixed
     */
    public function getData()
    {
        $data = parent::getData();

        $data['extendedOptions'][] = array('key' => 'authType', 'value' => 'auth');

        return $data;
    }
}
