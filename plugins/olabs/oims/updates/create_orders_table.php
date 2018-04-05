<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            // Order Status
            $table->integer("orderstatus_id")->unsigned()->nullable();
                    
            // User
            $table->integer("user_id")->unsigned()->nullable();
            // Delivery address
            $table->string("ds_first_name")->nullable();
            $table->string("ds_last_name")->nullable();
            $table->string("ds_address")->nullable();
            $table->string("ds_address_2")->nullable();
            $table->string("ds_postcode")->nullable();
            $table->string("ds_city")->nullable();
            $table->string("ds_country")->nullable();
            // Invoice address
            $table->string("is_first_name")->nullable();
            $table->string("is_last_name")->nullable();
            $table->string("is_address")->nullable();
            $table->string("is_address_2")->nullable();
            $table->string("is_postcode")->nullable();
            $table->string("is_city")->nullable();
            $table->string("is_country")->nullable();
            
            // Contact
            $table->string("contact_email")->nullable();
            $table->string("contact_phone")->nullable();
            
            // Carrier
            $table->integer("carrier_id")->unsigned()->nullable();
            
            // Products
            // propably save ID + qty + price, all other can be from producst DB
            $table->text("products_json")->nullable();
            
            // Price
            $table->double("total_price_without_tax")->nullable();
            $table->double("total_tax")->nullable();
            $table->double("total_price")->nullable();

            $table->double("shipping_price_without_tax")->nullable();
            $table->double("shipping_tax")->nullable();
            $table->double("shipping_price")->nullable();
            
            // Paid_date
            $table->timestamp("paid_date")->nullable();
            $table->text("paid_detail")->nullable();  // JSON
            $table->integer("payment_method")->unsigned()->nullable(); // Payment methods
            
            // Invoice - pdf
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_orders');
    }

}
