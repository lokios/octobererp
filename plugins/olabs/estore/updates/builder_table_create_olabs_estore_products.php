<?php namespace Olabs\Estore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsEstoreProducts extends Migration
{
    public function up()
    {
        Schema::create('olabs_estore_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('headline')->nullable();
            $table->decimal('sale_price', 10, 0)->nullable();
            $table->decimal('cost_price', 10, 0)->nullable();
            $table->string('status', 11)->nullable();
            $table->string('currency', 20)->nullable();
            $table->text('source')->nullable();
            $table->string('source_product_id')->nullable();
            $table->text('source_data')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_estore_products');
    }
}
