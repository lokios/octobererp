<?php namespace Olabs\Tasks\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsTasksTasks extends Migration
{
    public function up()
    {
        Schema::create('olabs_tasks_tasks', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->string('type', 255);
            $table->string('status', 12);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('code', 255)->nullable();
            $table->text('email_to')->nullable();
            $table->text('email_cc')->nullable();
            $table->text('email_bcc')->nullable();
            $table->text('email_subject')->nullable();
            $table->text('email_body')->nullable();
            $table->text('attachment_input1')->nullable();
            $table->text('attachment_input2')->nullable();
            $table->text('attachment_input3')->nullable();
            $table->text('attachment_input4')->nullable();
            $table->integer('tenant_id')->nullable();
            $table->string('schedule')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_tasks_tasks');
    }
}
