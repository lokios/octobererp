<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSchoolClassesTutors extends Migration
{
    public function up()
    {
        Schema::table('olabs_school_classes_tutors', function($table)
        {
            $table->integer('class_subjects_id')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_school_classes_tutors', function($table)
        {
            $table->dropColumn('class_subjects_id');
            $table->increments('id')->unsigned()->change();
        });
    }
}
