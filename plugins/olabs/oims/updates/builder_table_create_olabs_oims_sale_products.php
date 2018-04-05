<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsSaleProducts extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_sale_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('purchase_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('option_id')->nullable();
            $table->decimal('unit_price', 10, 0)->nullable();
            $table->decimal('quantity', 10, 0)->nullable();
            $table->decimal('total_price', 10, 0)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_sale_products');
    }
}
