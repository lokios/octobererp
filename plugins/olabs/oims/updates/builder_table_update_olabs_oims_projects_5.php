<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjects5 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->string('geocode_max_distance')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('geo_required')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->dropColumn('geocode_max_distance');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('geo_required');
        });
    }
}
