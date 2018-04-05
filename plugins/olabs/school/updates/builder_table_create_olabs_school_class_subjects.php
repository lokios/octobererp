<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsSchoolClassSubjects extends Migration
{
    public function up()
    {
        Schema::create('olabs_school_class_subjects', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('classes_id');
            $table->integer('subjects_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_school_class_subjects');
    }
}
