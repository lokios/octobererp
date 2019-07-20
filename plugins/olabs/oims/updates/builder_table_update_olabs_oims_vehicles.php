<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsVehicles extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_vehicles', function($table)
        {
            $table->renameColumn('type', 'vehicle_type');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_vehicles', function($table)
        {
            $table->renameColumn('vehicle_type', 'type');
        });
    }
}
