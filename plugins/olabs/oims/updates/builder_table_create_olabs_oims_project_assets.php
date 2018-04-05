<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsProjectAssets extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_project_assets', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('product_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('status')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('tenant_id')->nullable();
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->decimal('total_price_without_tax', 12, 2)->nullable();
            $table->decimal('total_tax', 12, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_project_assets');
    }
}
