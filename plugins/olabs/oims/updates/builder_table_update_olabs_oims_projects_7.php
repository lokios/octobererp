<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjects7 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->string('slug')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
