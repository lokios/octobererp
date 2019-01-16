<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsMessagingUsers extends Migration
{
    public function up()
    {
        Schema::rename('olabs_messaging_user_devices', 'olabs_messaging_users');
        Schema::table('olabs_messaging_users', function($table)
        {
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
        });
    }
    
    public function down()
    {
        Schema::rename('olabs_messaging_users', 'olabs_messaging_user_devices');
        Schema::table('olabs_messaging_user_devices', function($table)
        {
            $table->dropColumn('phone_no');
            $table->dropColumn('email');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
        });
    }
}
