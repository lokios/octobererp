<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateSampleData extends Migration
{

    public function up()
    {
        // Order statuses
        DB::statement("
            INSERT INTO `olabs_oims_order_statuses` (`id`, `created_at`, `updated_at`, `title`, `color`, `active`, `send_email_to_customer`, `attach_invoice_pdf_to_email`, `mail_template_id`) VALUES
            (1,	'2016-04-12 18:42:48',	'2016-05-08 18:50:48',	'New Order - Cash on Delivery',	'#f1c40f',	1,	1,	0,	null),
            (2,	'2016-05-08 17:42:37',	'2016-05-08 18:50:40',	'New Order - PayPal',	'#f1c40f',	1,	1,	0,	null),
            (3,	'2016-05-08 17:43:47',	'2016-05-08 18:50:32',	'New Order - Bank transfer',	'#f1c40f',	1,	1,	0,	null),
            (4,	'2016-05-08 17:44:54',	'2016-05-08 18:50:24',	'Payment Received',	'#9b59b6',	1,	1,	0,	null),
            (5,	'2016-05-08 17:45:13',	'2016-05-10 17:55:48',	'Cancel Order',	'#c0392b',	1,	1,	0,	null),
            (6,	'2016-05-08 17:45:55',	'2016-05-08 18:50:00',	'Expedited Order',	'#2ecc71',	1,	1,	1,	null),
            (7,	'2016-05-08 18:49:41',	'2016-05-08 18:49:41',	'Expedited Order - Cash on Delivery',	'#27ae60',	1,	1,	1,	null);"
                );
        
        // Carrier
        DB::statement("
            INSERT INTO `olabs_oims_carriers` (`id`, `created_at`, `updated_at`, `title`, `active`, `transit_time`, `speed_grade`, `tracking_url`, `free_shipping`, `tax_id`, `billing`, `billing_total_price`, `billing_weight`, `maximum_package_width`, `maximum_package_height`, `maximum_package_depth`, `maximum_package_weight`) VALUES
            (1,	'2016-04-12 16:04:00',	'2016-05-10 18:13:00',	'Carrier',	1,	'2 days',	0,	'http://exampl.com/track.php?num=@',	0,	1,	2,	'{\"1\":{\"from\":\"0\",\"to\":\"999999999999\",\"price\":\"11\"}}',	'{\"1\":{\"from\":\"0\",\"to\":\"9999\",\"price\":\"3.99\"}}',	NULL,	NULL,	NULL,	NULL);"
                );
        
        // Taxes
        DB::statement("
            INSERT INTO `olabs_oims_taxes` (`id`, `created_at`, `updated_at`, `name`, `active`, `percent`) VALUES
            (1,	'2016-04-12 15:09:17',	'2016-04-12 15:09:17',	'Default DPH',	1,	21),
            (2,	'2016-04-18 07:33:39',	'2016-04-18 07:33:39',	'Reduced DPH',	1,	15);"
                );
        
        // Setting
        DB::insert('INSERT INTO system_settings (item, value) values (?, ?)', [
            'olabs_oims_settings',
            '{"number_format_thousands_sep":",","number_format_decimals":"2","number_format_dec_point":".","bank_transfer_details_content":"","paypal_use_sandbox":"1","paypal_debug":"1","paypal_business":"","invoice_template_content":"<p><br>\r\n<\/p><table><colgroup><col><col><col><col><col><col><col><col><\/colgroup>\r\n<tbody>\r\n<tr>\r\n\t<td colspan=\"4\" rowspan=\"4\">\r\n\t\t<h2>JK Shop<\/h2>\r\n\t<\/td>\r\n\t<td colspan=\"4\" rowspan=\"4\">\r\n\t\t<h2>Invoice: #{{order_id}}<\/h2>\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n<\/tr>\r\n<tr>\r\n<\/tr>\r\n<tr>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">\r\n\t\t<h3>Supplier:<\/h3>\r\n\t<\/td>\r\n\t<td colspan=\"4\">\r\n\t\t<h3>Subscriber:<\/h3>\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"2\">Company No: 8546131657\r\n\t<\/td>\r\n\t<td colspan=\"2\">VAT number: US687465784\r\n\t<\/td>\r\n\t<td colspan=\"2\">Company No:\r\n\t<\/td>\r\n\t<td colspan=\"2\">VAT number:\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">JKShop\r\n\t<\/td>\r\n\t<td colspan=\"4\">Firm\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">Jiri Kubak\r\n\t<\/td>\r\n\t<td colspan=\"4\">{{first_name}}   {{last_name}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">Address\r\n\t<\/td>\r\n\t<td colspan=\"4\">{{address}} {{address2}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">Postcode City\r\n\t<\/td>\r\n\t<td colspan=\"4\">{{postcode}}   {{city}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">Country<br>\r\n\t<\/td>\r\n\t<td colspan=\"4\">{{country}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">E mail: xx@yy.com\r\n\t<\/td>\r\n\t<td colspan=\"4\">Email:   {{email}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">Phone: 555 666 222\r\n\t<\/td>\r\n\t<td colspan=\"4\">Phone:   {{phone}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">\r\n\t\t<h3>Bank Details:<\/h3>\r\n\t<\/td>\r\n\t<td colspan=\"4\">\r\n\t\t<h3>Delivery Adress:<\/h3>\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"2\">Account Number:\r\n\t<\/td>\r\n\t<td colspan=\"2\">568741316\/2548\r\n\t<\/td>\r\n\t<td colspan=\"4\">{{ds_first_name}}   {{ds_last_name}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"2\">Bank name:\r\n\t<\/td>\r\n\t<td colspan=\"2\">Europa Bank\r\n\t<\/td>\r\n\t<td colspan=\"4\">{{ds_address}} {{ds_address2}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">\r\n\t<\/td>\r\n\t<td colspan=\"4\">{{ds_postcode}} {{ds_city}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">\r\n\t<\/td>\r\n\t<td colspan=\"4\">{{ds_country}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"8\">\r\n\t\t<h3>Payment   Terms<\/h3>\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"2\">Date of Issue:\r\n\t<\/td>\r\n\t<td colspan=\"2\">{{date_now}}\r\n\t<\/td>\r\n\t<td colspan=\"2\">No.:\r\n\t<\/td>\r\n\t<td colspan=\"2\">{{order_id}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"2\">Due Date:\r\n\t<\/td>\r\n\t<td colspan=\"2\">{{date_now_14}}\r\n\t<\/td>\r\n\t<td colspan=\"4\"><br>\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"2\">Form of Payment:\r\n\t<\/td>\r\n\t<td colspan=\"2\">{{payment_method}}\r\n\t<\/td>\r\n\t<td colspan=\"4\">\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"8\"><br>\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"8\">\r\n\t\t<h3>Products<\/h3>\r\n\t<\/td>\r\n<\/tr>\r\n\r\n<tr>\r\n\t<td colspan=\"8\">\r\n\t\t{{products}}\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">\r\n\t<\/td>\r\n\t<td colspan=\"3\">Total   excl. VAT:\r\n\t<\/td>\r\n\t<td style=\"text-align: right;\"><strong>{{total_price_without_tax}}<\/strong>\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">\r\n\t<\/td>\r\n\t<td colspan=\"3\">VAT:\r\n\t<\/td>\r\n\t<td style=\"text-align: right;\"><strong>{{total_tax}}<\/strong>\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\">\r\n\t<\/td>\r\n\t<td colspan=\"3\">Total   incl. VAT:\r\n\t<\/td>\r\n\t<td style=\"text-align: right;\"><strong>{{total_price}}<\/strong>\r\n\t<\/td>\r\n<\/tr>\r\n<tr>\r\n\t<td colspan=\"4\"><br><br><br>Issued: JKShop\r\n\t<\/td>\r\n\t<td colspan=\"4\"><br><br><br>Took Over:\r\n\t<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table><p><br>\r\n<\/p>","cash_on_delivery_order_status_before_id":"1","cash_on_delivery_order_status_after_id":"6","bank_transfer_order_status_before_id":"3","bank_transfer_order_status_after_id":"4","paypal_order_status_before_id":"2","paypal_order_status_after_id":"4","currency_char":"$","currency_char_position":"1","copy_all_order_emails_to":"","invoice_template_style":".product-title { width: 315px; display: inline-block; }\r\n.product-quantity { width: 50px; display: inline-block; }\r\n.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }\r\n.product-tax { width: 100px; display: inline-block; text-align: right; }\r\n.product-price { width: 130px; display: inline-block; text-align: right; }\r\ntable { width: 100%; border-collapse: collapse;}\r\ntd, th { border: 1px solid #ccc; }","cash_on_delivery_active":"1","bank_transfer_active":"1","paypal_active":"0","paypal_currency_code":"USD","paypal_return_url":""}'
            ]);
    }

    public function down()
    {
        DB::statement("DELETE FROM system_settings where item = 'olabs_oims_settings'");
        //Schema::dropIfExists('olabs_oims_brands');
    }

}
