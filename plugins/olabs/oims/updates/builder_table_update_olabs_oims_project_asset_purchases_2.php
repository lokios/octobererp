<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssetPurchases2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_asset_purchases', function($table)
        {
            $table->integer('product_id')->nullable()->change();
            $table->integer('project_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_asset_purchases', function($table)
        {
            $table->integer('product_id')->nullable(false)->change();
            $table->integer('project_id')->nullable(false)->change();
        });
    }
}
