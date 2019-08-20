-- 21/08/2019
ALTER TABLE `olabs_oims_purchases` ADD INDEX(`project_id`);
ALTER TABLE `olabs_oims_purchases` ADD INDEX(`context_date`);
ALTER TABLE `olabs_oims_purchases` ADD INDEX(`user_id`);
ALTER TABLE `olabs_oims_purchases` ADD INDEX(`status`);
ALTER TABLE `olabs_oims_purchase_products` ADD INDEX(`purchase_id`);

ALTER TABLE `olabs_oims_status_history` ADD INDEX(`entity_id`);
ALTER TABLE `olabs_oims_status_history` ADD INDEX(`entity_type`);
ALTER TABLE `olabs_oims_status_history` ADD INDEX(`status`);
