<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsAssets extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_assets', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('condition')->nullable();
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->decimal('total_price_without_tax', 12, 2)->nullable();
            $table->decimal('total_tax', 12, 2)->nullable();
            $table->string('status')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_assets');
    }
}
