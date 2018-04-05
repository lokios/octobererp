<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssetMonitoring2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_asset_monitoring', function($table)
        {
            $table->renameColumn('descriptions', 'description');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_asset_monitoring', function($table)
        {
            $table->renameColumn('description', 'descriptions');
        });
    }
}
