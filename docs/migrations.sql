-- 09/04/2019

UPDATE `olabs_oims_products` set tax_id = 1, `pre_tax_retail_price` = retail_price_with_tax
UPDATE `olabs_oims_products` set tax_id = 0 where tax_id = 1
