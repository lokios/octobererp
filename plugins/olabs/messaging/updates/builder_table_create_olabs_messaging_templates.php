<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsMessagingTemplates extends Migration
{
    public function up()
    {
        Schema::create('olabs_messaging_templates', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('iam_template')->nullable();
            $table->text('sms_template')->nullable();
            $table->text('email_template')->nullable();
            $table->text('device_template')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_messaging_templates');
    }
}
