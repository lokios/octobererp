<?php namespace Olabs\Pusher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsPusherActivity extends Migration
{
    public function up()
    {
        Schema::create('olabs_pusher_activity', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('tenant_id')->nullable();
            $table->text('title')->nullable();
            $table->text('message')->nullable();
            $table->text('action')->nullable();
            $table->string('status', 10)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('channel', 255)->nullable();
            $table->text('channel_type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_pusher_activity');
    }
}
