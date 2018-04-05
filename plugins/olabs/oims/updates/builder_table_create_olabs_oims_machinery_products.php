<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsMachineryProducts extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_machinery_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('machinery_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('option_id')->nullable();
            $table->decimal('unit_price', 10, 0)->nullable();
            $table->decimal('quantity', 10, 0)->nullable();
            $table->decimal('total_price', 10, 0)->nullable();
            $table->string('unit', 255)->nullable();
            $table->decimal('unit_value', 10, 2)->nullable();
            $table->string('remark', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_machinery_products');
    }
}
