<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsCompanies2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_companies', function($table)
        {
            $table->string('tin')->nullable();
            $table->string('pan')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_companies', function($table)
        {
            $table->dropColumn('tin');
            $table->dropColumn('pan');
        });
    }
}
