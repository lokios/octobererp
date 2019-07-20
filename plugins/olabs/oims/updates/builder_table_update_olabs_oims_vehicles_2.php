<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsVehicles2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_vehicles', function($table)
        {
            $table->renameColumn('lenght', 'length');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_vehicles', function($table)
        {
            $table->renameColumn('length', 'lenght');
        });
    }
}
