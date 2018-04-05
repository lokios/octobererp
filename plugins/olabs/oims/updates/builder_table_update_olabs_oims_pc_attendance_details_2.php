<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPcAttendanceDetails2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_pc_attendance_details', function($table)
        {
            $table->decimal('working_hour', 12, 2)->nullable();
            $table->decimal('overtime', 12, 2)->nullable();
            $table->decimal('total_working_hour', 12, 2)->nullable();
            $table->decimal('total_wages', 12, 2)->nullable();
            $table->renameColumn('unit_price', 'daily_wages');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_pc_attendance_details', function($table)
        {
            $table->dropColumn('working_hour');
            $table->dropColumn('overtime');
            $table->dropColumn('total_working_hour');
            $table->dropColumn('total_wages');
            $table->renameColumn('daily_wages', 'unit_price');
        });
    }
}
