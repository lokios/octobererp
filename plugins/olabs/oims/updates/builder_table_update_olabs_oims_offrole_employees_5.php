<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsOffroleEmployees5 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->integer('lunch_hour')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->dropColumn('lunch_hour');
        });
    }
}
