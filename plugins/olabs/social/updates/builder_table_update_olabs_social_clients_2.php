<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSocialClients2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_social_clients', function($table)
        {
            $table->string('fcm_access_key')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_social_clients', function($table)
        {
            $table->dropColumn('fcm_access_key');
        });
    }
}
