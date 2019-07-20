<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsVehicles extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_vehicles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->dateTime('context_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->text('description')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('name')->nullable();
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->decimal('lenght', 12, 2)->nullable();
            $table->decimal('width', 12, 2)->nullable();
            $table->decimal('height', 12, 2)->nullable();
            $table->string('unit')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_vehicles');
    }
}
