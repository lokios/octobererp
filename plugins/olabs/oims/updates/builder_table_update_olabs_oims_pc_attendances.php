<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPcAttendances extends Migration
{
    public function up()
    {
        Schema::rename('olabs_oims_pc_attendance', 'olabs_oims_pc_attendances');
    }
    
    public function down()
    {
        Schema::rename('olabs_oims_pc_attendances', 'olabs_oims_pc_attendance');
    }
}
