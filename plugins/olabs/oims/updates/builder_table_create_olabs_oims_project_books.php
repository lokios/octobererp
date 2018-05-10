<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsProjectBooks extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_project_books', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('series_from')->nullable();
            $table->integer('series_to')->nullable();
            $table->string('type')->nullable();
            $table->dateTime('context_date')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('status')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_project_books');
    }
}
