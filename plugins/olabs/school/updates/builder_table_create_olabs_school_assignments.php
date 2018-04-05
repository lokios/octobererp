<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsSchoolAssignments extends Migration
{
    public function up()
    {
        Schema::create('olabs_school_assignments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('name')->nullable();
            $table->text('description');
            $table->text('status')->nullable();
            $table->dateTime('published_date');
            $table->dateTime('published_end_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('class_subjects_id');
            $table->integer('classes_tutors_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_school_assignments');
    }
}
