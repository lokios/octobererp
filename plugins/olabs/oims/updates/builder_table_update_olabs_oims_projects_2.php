<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjects2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->decimal('fix_expense', 10, 0)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->dropColumn('fix_expense');
        });
    }
}
