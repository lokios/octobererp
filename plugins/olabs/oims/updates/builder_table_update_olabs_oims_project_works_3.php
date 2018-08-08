<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectWorks3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->integer('work_days')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->dropColumn('work_days');
        });
    }
}
