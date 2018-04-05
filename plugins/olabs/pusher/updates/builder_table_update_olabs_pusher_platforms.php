<?php namespace Olabs\Pusher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsPusherPlatforms extends Migration
{
    public function up()
    {
        Schema::rename('olabs_pusher_registrations', 'olabs_pusher_platforms');
    }
    
    public function down()
    {
        Schema::rename('olabs_pusher_platforms', 'olabs_pusher_registrations');
    }
}
