<?php namespace Olabs\Pusher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsPusherPlatforms2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_pusher_platforms', function($table)
        {
            $table->string('app_id')->nullable();
            $table->text('device_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_pusher_platforms', function($table)
        {
            $table->dropColumn('app_id');
            $table->dropColumn('device_id');
        });
    }
}
