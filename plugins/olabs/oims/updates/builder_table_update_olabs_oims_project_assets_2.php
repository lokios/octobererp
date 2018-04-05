<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssets2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_assets', function($table)
        {
            $table->integer('project_id')->nullable();
            $table->integer('purchase_id')->nullable();
            $table->dropColumn('category_id');
            $table->dropColumn('brand_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_assets', function($table)
        {
            $table->dropColumn('project_id');
            $table->dropColumn('purchase_id');
            $table->integer('category_id')->nullable();
            $table->integer('brand_id')->nullable();
        });
    }
}
