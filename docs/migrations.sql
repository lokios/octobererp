-- 09/04/2019

UPDATE `olabs_oims_products` set tax_id = 1, `pre_tax_retail_price` = retail_price_with_tax;
UPDATE `olabs_oims_products` set tax_id = 0 where tax_id = 1;


UPDATE `olabs_oims_quote_products`  set pre_tax_retail_price = unit_price;
UPDATE `olabs_oims_quote_products`  set tax_percent = 0;
UPDATE `olabs_oims_quote_products`  set total_tax = 0;
