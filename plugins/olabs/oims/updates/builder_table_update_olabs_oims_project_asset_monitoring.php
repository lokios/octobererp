<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssetMonitoring extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_asset_monitoring', function($table)
        {
            $table->text('descriptions')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_asset_monitoring', function($table)
        {
            $table->dropColumn('descriptions');
        });
    }
}
