<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsAttendances extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_attendances', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('project_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->decimal('daily_wages', 10, 0)->nullable();
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->decimal('total_working_hour', 10, 0)->nullable();
            $table->decimal('total_wages', 10, 0)->nullable();
            $table->decimal('overtime', 10, 0)->nullable();
            $table->string('status')->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_attendances');
    }
}
