<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssetDamages extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_asset_damages', function($table)
        {
            $table->dateTime('context_date')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_asset_damages', function($table)
        {
            $table->dropColumn('context_date');
            $table->increments('id')->unsigned()->change();
        });
    }
}
