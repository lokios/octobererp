<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsProjectProgressItems extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_project_progress_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('work_id')->nullable();
            $table->decimal('quantity', 10, 0)->nullable();
            $table->string('unit')->nullable();
            $table->decimal('unit_price', 10, 0)->nullable();
            $table->decimal('total_price', 10, 0)->nullable();
            $table->text('description')->nullable();
            $table->integer('project_progress_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_project_progress_items');
    }
}
