<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSchoolSubjectTopics extends Migration
{
    public function up()
    {
        Schema::table('olabs_school_subject_topics', function($table)
        {
            $table->integer('subjects_id');
            $table->integer('tenant_id');
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_school_subject_topics', function($table)
        {
            $table->dropColumn('subjects_id');
            $table->dropColumn('tenant_id');
            $table->increments('id')->unsigned()->change();
        });
    }
}
