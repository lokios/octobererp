<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsSocialNotifications extends Migration
{
    public function up()
    {
        Schema::create('olabs_social_notifications', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tenant_id')->nullable();
            $table->integer('actor_id')->nullable();
            $table->text('data')->nullable();
            $table->string('status', 255)->nullable();
            $table->string('context_type', 255)->nullable();
            $table->integer('context_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('reminder_type', 255)->nullable();
            $table->integer('reminders_count')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('sms_status', 12)->nullable();
            $table->string('email_status', 12)->nullable();
            $table->string('mobile_push_status', 12)->nullable();
            $table->integer('sms_count')->nullable();
            $table->integer('email_count')->nullable();
            $table->integer('mobile_push_count')->nullable();
            $table->string('web_push_status', 12)->nullable();
            $table->integer('web_push_count')->nullable();
            $table->dateTime('sms_sent_at')->nullable();
            $table->dateTime('email_sent_at')->nullable();
            $table->dateTime('mobile_push_sent_at')->nullable();
            $table->dateTime('web_push_sent_at')->nullable();
            $table->string('excerpt', 255)->nullable();
            $table->string('action_type', 255)->nullable();
            $table->integer('peer_tenant_id')->nullable();
            $table->integer('peer_branch_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_social_notifications');
    }
}
