<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSchoolClassesTutors2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_school_classes_tutors', function($table)
        {
            $table->integer('tenant_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_school_classes_tutors', function($table)
        {
            $table->dropColumn('tenant_id');
        });
    }
}
