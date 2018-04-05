<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsPcAttendance extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_pc_attendance', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('ds_first_name')->nullable();
            $table->string('ds_last_name')->nullable();
            $table->string('ds_address')->nullable();
            $table->string('ds_address_2')->nullable();
            $table->string('ds_postcode')->nullable();
            $table->string('ds_city')->nullable();
            $table->string('ds_country')->nullable();
            $table->string('is_first_name')->nullable();
            $table->string('is_last_name')->nullable();
            $table->string('is_address')->nullable();
            $table->string('is_address_2')->nullable();
            $table->string('is_postcode')->nullable();
            $table->string('is_city')->nullable();
            $table->string('is_country')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->integer('carrier_id')->nullable();
            $table->text('products_json')->nullable();
            $table->decimal('total_price_without_tax', 12, 2)->nullable();
            $table->decimal('total_tax', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->decimal('shipping_price_without_tax', 12, 2)->nullable();
            $table->decimal('shipping_tax', 12, 2)->nullable();
            $table->decimal('shipping_price', 12, 2)->nullable();
            $table->text('paid_detail')->nullable();
            $table->integer('payment_method')->nullable();
            $table->text('note')->nullable();
            $table->string('ds_county')->nullable();
            $table->string('is_county')->nullable();
            $table->string('tracking_number')->nullable();
            $table->decimal('total_global_discount', 12, 2)->nullable();
            $table->integer('coupon_id')->nullable();
            $table->integer('payment_gateway_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('status')->nullable();
            $table->string('reference_number')->nullable();
            $table->dateTime('context_date')->nullable();
            $table->dateTime('paid_date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_pc_attendance');
    }
}
