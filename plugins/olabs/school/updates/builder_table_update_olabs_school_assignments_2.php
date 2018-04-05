<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSchoolAssignments2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_school_assignments', function($table)
        {
            $table->integer('classrooms_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_school_assignments', function($table)
        {
            $table->dropColumn('classrooms_id');
        });
    }
}
