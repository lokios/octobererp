<?php namespace Olabs\Pusher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsPusherRegistrations extends Migration
{
    public function up()
    {
        Schema::create('olabs_pusher_registrations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('device_type', 255)->nullable();
            $table->string('channel', 255)->nullable();
            $table->text('reg_id')->nullable();
            $table->string('user_id', 255)->nullable();
            $table->string('status', 10)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_pusher_registrations');
    }
}
