<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssetTransfers2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_asset_transfers', function($table)
        {
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_asset_transfers', function($table)
        {
            $table->dropColumn('deleted_at');
        });
    }
}
