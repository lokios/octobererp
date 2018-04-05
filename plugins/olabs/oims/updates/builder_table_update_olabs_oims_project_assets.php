<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssets extends Migration
{
    public function up()
    {
        Schema::rename('olabs_oims_assets', 'olabs_oims_project_assets');
    }
    
    public function down()
    {
        Schema::rename('olabs_oims_project_assets', 'olabs_oims_assets');
    }
}
