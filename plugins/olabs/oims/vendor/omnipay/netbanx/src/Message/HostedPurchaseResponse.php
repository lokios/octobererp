<?php

namespace Omnipay\NetBanx\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class HostedPurchaseResponse extends HostedAbstractResponse implements RedirectResponseInterface
{
    /**
     * @return bool
     */
    public function isRedirect()
    {
        $hasHostedLink = false;
        if (isset($this->data['link'])) {
            foreach ($this->data['link'] as $link) {
                if (isset($link['rel']) && $link['rel'] == 'hosted_payment') {
                    $hasHostedLink = true;
                }
            }
        }

        $hasTransaction = isset($this->data['transaction']);

        // No transaction should exist yet if this is a new hosted netbanx order
        return $hasHostedLink && !$hasTransaction;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl()
    {
        if (isset($this->data['link'])) {
            foreach ($this->data['link'] as $link) {
                if (isset($link['rel']) && $link['rel'] == 'hosted_payment') {
                    return $link['uri'];
                }
            }
        }
    }

    /**
     * @return null
     */
    public function getRedirectData()
    {
        return null;
    }
}
