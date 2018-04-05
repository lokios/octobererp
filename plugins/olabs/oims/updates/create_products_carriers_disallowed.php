<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProductsCarriersDisallowed extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_products_carriers_no', function($table)
        {
            $table->integer('product_id')->unsigned();
            $table->integer('carrier_id')->unsigned();
            $table->primary(['product_id', 'carrier_id']);         
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_products_carriers_no');
    }

}