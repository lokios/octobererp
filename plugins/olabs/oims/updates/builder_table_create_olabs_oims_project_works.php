<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsProjectWorks extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_project_works', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('work_group_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('unit')->nullable();
            $table->double('unit_price', 10, 0)->nullable();
            $table->double('quantity', 10, 0)->nullable();
            $table->double('total_amount', 10, 0)->nullable();
            $table->string('reference_number')->nullable();
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
        Schema::dropIfExists('olabs_oims_project_works');
    }
}
