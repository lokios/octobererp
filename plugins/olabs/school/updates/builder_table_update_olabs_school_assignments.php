<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSchoolAssignments extends Migration
{
    public function up()
    {
        Schema::table('olabs_school_assignments', function($table)
        {
            $table->integer('subject_topics_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_school_assignments', function($table)
        {
            $table->dropColumn('subject_topics_id');
        });
    }
}
