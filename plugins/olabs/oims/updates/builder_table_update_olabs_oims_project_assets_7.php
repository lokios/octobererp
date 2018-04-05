<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssets7 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_assets', function($table)
        {
            $table->string('name', 255)->nullable()->change();
            $table->integer('product_id')->nullable(false)->change();
            $table->integer('project_id')->nullable(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_assets', function($table)
        {
            $table->string('name', 255)->nullable(false)->change();
            $table->integer('product_id')->nullable()->change();
            $table->integer('project_id')->nullable()->change();
        });
    }
}
