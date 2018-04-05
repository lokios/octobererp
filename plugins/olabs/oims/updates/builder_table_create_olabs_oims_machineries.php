<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsMachineries extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_machineries', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('user_id')->nullable()->unsigned();
            $table->string('ds_first_name', 255)->nullable();
            $table->string('ds_last_name', 255)->nullable();
            $table->string('ds_address', 255)->nullable();
            $table->string('ds_address_2', 255)->nullable();
            $table->string('ds_postcode', 255)->nullable();
            $table->string('ds_city', 255)->nullable();
            $table->string('ds_country', 255)->nullable();
            $table->string('is_first_name', 255)->nullable();
            $table->string('is_last_name', 255)->nullable();
            $table->string('is_address', 255)->nullable();
            $table->string('is_address_2', 255)->nullable();
            $table->string('is_postcode', 255)->nullable();
            $table->string('is_city', 255)->nullable();
            $table->string('is_country', 255)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('contact_phone', 255)->nullable();
            $table->integer('carrier_id')->nullable()->unsigned();
            $table->text('products_json')->nullable();
            $table->double('total_price_without_tax', 10, 0)->nullable();
            $table->double('total_tax', 10, 0)->nullable();
            $table->double('total_price', 10, 0)->nullable();
            $table->double('shipping_price_without_tax', 10, 0)->nullable();
            $table->double('shipping_tax', 10, 0)->nullable();
            $table->double('shipping_price', 10, 0)->nullable();
            $table->dateTime('paid_date')->nullable();
            $table->text('paid_detail')->nullable();
            $table->integer('payment_method')->nullable()->unsigned();
            $table->text('note')->nullable();
            $table->string('ds_county', 255)->nullable();
            $table->string('is_county', 255)->nullable();
            $table->string('tracking_number', 255)->nullable();
            $table->double('total_global_discount', 10, 0)->nullable();
            $table->integer('coupon_id')->nullable();
            $table->integer('payment_gateway_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->string('status', 255)->nullable();
            $table->string('reference_number', 255)->nullable();
            $table->dateTime('context_date')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_machineries');
    }
}
