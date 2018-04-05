<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsProjectAssetTransfers extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_project_asset_transfers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('project_id')->nullable();
            $table->integer('to_project_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->dateTime('context_date')->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->string('unit')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('descriptions')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_project_asset_transfers');
    }
}
