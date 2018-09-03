<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjects6 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->integer('customer_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->dropColumn('customer_id');
        });
    }
}
