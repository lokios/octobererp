<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProductsProperties extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_products_properties', function($table)
        {
            $table->integer('product_id')->unsigned();
            $table->integer('property_id')->unsigned();
            $table->primary(['product_id', 'property_id']);
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_products_properties');
    }

}