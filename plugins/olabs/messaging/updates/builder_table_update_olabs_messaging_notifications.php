<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsMessagingNotifications extends Migration
{
    public function up()
    {
        Schema::table('olabs_messaging_notifications', function($table)
        {
            $table->string('circle_code')->nullable();
            $table->string('fcm_access_key')->nullable();
            $table->renameColumn('meta', 'data');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_messaging_notifications', function($table)
        {
            $table->dropColumn('circle_code');
            $table->dropColumn('fcm_access_key');
            $table->renameColumn('data', 'meta');
        });
    }
}
