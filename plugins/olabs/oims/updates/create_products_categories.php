<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProductsCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_products_categories', function($table)
        {
            $table->integer('product_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['product_id', 'category_id']);         
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_products_categories');
    }

}