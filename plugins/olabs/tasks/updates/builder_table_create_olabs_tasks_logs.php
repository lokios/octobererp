<?php namespace Olabs\Tasks\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsTasksLogs extends Migration
{
    public function up()
    {
        Schema::create('olabs_tasks_logs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('log')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('name', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_tasks_logs');
    }
}
