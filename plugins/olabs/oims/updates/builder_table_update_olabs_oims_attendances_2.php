<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsAttendances2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_attendances', function($table)
        {
            $table->string('employee_type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_attendances', function($table)
        {
            $table->dropColumn('employee_type');
        });
    }
}
