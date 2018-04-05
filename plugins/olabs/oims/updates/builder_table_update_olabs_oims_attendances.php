<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsAttendances extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_attendances', function($table)
        {
            $table->integer('working_hour')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_attendances', function($table)
        {
            $table->dropColumn('working_hour');
        });
    }
}
