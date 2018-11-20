<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsCompanies3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_companies', function($table)
        {
            $table->string('slug')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_companies', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
