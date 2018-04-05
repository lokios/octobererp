<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsOffroleEmployees extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->string('employee_type', 255)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->integer('employee_type')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
