<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsProjectAssetMonitoring extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_project_asset_monitoring', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('project_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->string('unit')->nullable();
            $table->dateTime('context_date')->nullable();
            $table->string('condition_type')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_project_asset_monitoring');
    }
}
