<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsSchoolClassesTutors extends Migration
{
    public function up()
    {
        Schema::create('olabs_school_classes_tutors', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->text('username')->nullable();
            $table->text('headline')->nullable();
            $table->text('status')->nullable();
            $table->text('created_at')->nullable();
            $table->text('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_school_classes_tutors');
    }
}
