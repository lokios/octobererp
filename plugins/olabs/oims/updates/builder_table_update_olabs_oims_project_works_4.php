<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectWorks4 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->dateTime('planned_start_date')->nullable();
            $table->dateTime('planned_end_date')->nullable();
            $table->integer('work_days')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->dropColumn('planned_start_date');
            $table->dropColumn('planned_end_date');
            $table->integer('work_days')->unsigned()->change();
        });
    }
}
