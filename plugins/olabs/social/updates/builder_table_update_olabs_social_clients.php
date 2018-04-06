<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSocialClients extends Migration
{
    public function up()
    {
        Schema::table('olabs_social_clients', function($table)
        {
            $table->decimal('sms_rate', 11, 2)->nullable()->default(0.00);
            $table->decimal('email_rate', 11, 2)->nullable()->default(0.00);
        });
    }
    
    public function down()
    {
        Schema::table('olabs_social_clients', function($table)
        {
            $table->dropColumn('sms_rate');
            $table->dropColumn('email_rate');
        });
    }
}
