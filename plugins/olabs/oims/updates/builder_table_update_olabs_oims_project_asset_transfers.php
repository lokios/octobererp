<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssetTransfers extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_asset_transfers', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->renameColumn('descriptions', 'description');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_asset_transfers', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->renameColumn('description', 'descriptions');
        });
    }
}
