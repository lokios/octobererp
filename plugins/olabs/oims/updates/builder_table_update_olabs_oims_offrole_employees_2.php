<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsOffroleEmployees2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->string('employee_code')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->dropColumn('employee_code');
        });
    }
}
