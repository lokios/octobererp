<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsMessagingNotifications2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_messaging_notifications', function($table)
        {
            $table->integer('tenant_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_messaging_notifications', function($table)
        {
            $table->dropColumn('tenant_id');
        });
    }
}
