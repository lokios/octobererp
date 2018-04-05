<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsOffroleEmployees3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->integer('working_hour')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->dropColumn('working_hour');
        });
    }
}
