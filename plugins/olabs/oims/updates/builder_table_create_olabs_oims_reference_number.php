<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsReferenceNumber extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_reference_number', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type')->nullable();
            $table->integer('sequence')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('start_from')->nullable();
            $table->date('reference_date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_reference_number');
    }
}
