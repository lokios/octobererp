<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsMessagingCircleMembers extends Migration
{
    public function up()
    {
        Schema::table('olabs_messaging_circle_members', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('fcm_token')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_messaging_circle_members', function($table)
        {
            $table->dropColumn('id');
            $table->dropColumn('username');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone_no');
            $table->dropColumn('email');
            $table->dropColumn('fcm_token');
        });
    }
}
