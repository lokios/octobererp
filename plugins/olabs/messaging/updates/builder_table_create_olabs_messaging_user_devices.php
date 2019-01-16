<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsMessagingUserDevices extends Migration
{
    public function up()
    {
        Schema::create('olabs_messaging_user_devices', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('type')->nullable();
            $table->integer('user_id')->nullable()->unsigned();
            $table->string('username')->nullable();
            $table->string('status')->nullable();
            $table->string('fcm_token')->nullable();
            $table->dateTime('fcm_token_datetime')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_messaging_user_devices');
    }
}
