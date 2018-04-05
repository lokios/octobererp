<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsStatusHistory extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_status_history', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('entity_id')->nullable();
            $table->string('entity_type')->nullable();
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_status_history');
    }
}
