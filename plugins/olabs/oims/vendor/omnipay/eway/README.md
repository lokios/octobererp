# Omnipay: eWAY

**eWAY driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/thephpleague/omnipay-eway.png?branch=master)](https://travis-ci.org/thephpleague/omnipay-eway)
[![Latest Stable Version](https://poser.pugx.org/omnipay/eway/version.png)](https://packagist.org/packages/omnipay/eway)
[![Total Downloads](https://poser.pugx.org/omnipay/eway/d/total.png)](https://packagist.org/packages/omnipay/eway)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements eWAY support for Omnipay.

[eWay](https://eway.io/about-eway) was launched in Australia in 1998 and now operates payment gateways
in 8 countries.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "omnipay/eway": "~2.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Eway_Direct -- This gateway is deprecated.  If you have existing code that uses it you can continue
  to do so but you should consider migrating to Eway_RapidDirect
* Eway_RapidDirect -- This is the primary gateway used for direct card processing, i.e. where you collect the
  card details from the customer and pass them to eWay yourself via the API.
* Eway_Rapid --  This is used for eWAY Rapid Transparent Redirect requests.  The gateway is just
  called Eway_Rapid as it was the first implemented.  Like other redirect gateways the purchase() call
  will return a redirect response and then requires you to redirect the customer to the eWay site for
  the actual purchase.
* Eway_RapidShared -- This provides a hosted form for entering payment information, other than that
  it is similar to the Eway_Rapid gateway in functionality.

See the docblocks within the gateway classes for further information and links to the eWay gateway on
line.

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/thephpleague/omnipay-eway/issues),
or better yet, fork the library and submit a pull request.
