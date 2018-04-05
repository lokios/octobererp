<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssetMonitoring3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_asset_monitoring', function($table)
        {
            $table->integer('tenant_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_asset_monitoring', function($table)
        {
            $table->dropColumn('tenant_id');
        });
    }
}
