<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProductsProductsAccessories extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_products_accessories', function($table)
        {
            $table->integer('product_id')->unsigned();
            $table->integer('accessory_id')->unsigned();
            $table->primary(['product_id', 'accessory_id']);
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_products_accessories');
    }

}