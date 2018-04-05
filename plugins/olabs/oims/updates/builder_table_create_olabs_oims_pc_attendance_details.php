<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsPcAttendanceDetails extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_pc_attendance_details', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('attendance_id')->nullable();
            $table->string('employee_type')->nullable();
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->decimal('quantity', 12, 12)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            
            
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_pc_attendance_details');
    }
}

