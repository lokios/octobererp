<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsVehicleProjects extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_vehicle_projects', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('vehicle_id');
            $table->integer('project_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_vehicle_projects');
    }
}
