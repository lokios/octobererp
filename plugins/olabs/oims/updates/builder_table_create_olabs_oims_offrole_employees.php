<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsOffroleEmployees extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_offrole_employees', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->decimal('daily_wages', 10, 0)->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('status')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('last_working_date')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('employee_type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_offrole_employees');
    }
}
