<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectWorks6 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->decimal('labour_coefficient', 10, 0)->nullable();
            $table->decimal('labour_unit_price', 10, 0)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->dropColumn('labour_coefficient');
            $table->dropColumn('labour_unit_price');
        });
    }
}
