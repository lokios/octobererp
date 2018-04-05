<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssetDamages3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_asset_damages', function($table)
        {
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->decimal('total_price_without_tax', 12, 2)->nullable();
            $table->decimal('total_tax', 12, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_asset_damages', function($table)
        {
            $table->dropColumn('unit_price');
            $table->dropColumn('total_price');
            $table->dropColumn('total_price_without_tax');
            $table->dropColumn('total_tax');
        });
    }
}
