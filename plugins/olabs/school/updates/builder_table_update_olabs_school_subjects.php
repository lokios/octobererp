<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSchoolSubjects extends Migration
{
    public function up()
    {
        Schema::table('olabs_school_subjects', function($table)
        {
            $table->integer('tenant_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_school_subjects', function($table)
        {
            $table->dropColumn('tenant_id');
        });
    }
}
