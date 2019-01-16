<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsMessagingNotifications extends Migration
{
    public function up()
    {
        Schema::create('olabs_messaging_notifications', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('tenant_code')->nullable();
            $table->string('status')->nullable();
            $table->integer('actor_id')->nullable();
            $table->integer('context_id')->nullable();
            $table->string('context_type')->nullable();
            $table->text('meta')->nullable();
            $table->text('descriptions')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('callback_url')->nullable();
            $table->text('callback_params')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_messaging_notifications');
    }
}
