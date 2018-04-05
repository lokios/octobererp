<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPcAttendanceDetails extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_pc_attendance_details', function($table)
        {
            $table->decimal('quantity', 12, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_pc_attendance_details', function($table)
        {
            $table->decimal('quantity', 12, 12)->change();
        });
    }
}
