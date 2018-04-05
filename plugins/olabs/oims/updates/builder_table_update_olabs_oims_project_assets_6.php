<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectAssets6 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_assets', function($table)
        {
            $table->string('unit')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_assets', function($table)
        {
            $table->dropColumn('unit');
        });
    }
}
