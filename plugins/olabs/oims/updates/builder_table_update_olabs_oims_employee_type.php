<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsEmployeeType extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_employee_type', function($table)
        {
            $table->string('status')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_employee_type', function($table)
        {
            $table->dropColumn('status');
            $table->increments('id')->unsigned()->change();
        });
    }
}
