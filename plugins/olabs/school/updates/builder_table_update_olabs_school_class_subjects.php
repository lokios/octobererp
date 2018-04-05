<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSchoolClassSubjects extends Migration
{
    public function up()
    {
        Schema::table('olabs_school_class_subjects', function($table)
        {
            $table->renameColumn('classes_id', 'classrooms_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_school_class_subjects', function($table)
        {
            $table->renameColumn('classrooms_id', 'classes_id');
        });
    }
}
