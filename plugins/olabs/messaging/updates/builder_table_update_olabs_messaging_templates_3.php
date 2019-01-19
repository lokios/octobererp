<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsMessagingTemplates3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_messaging_templates', function($table)
        {
            $table->renameColumn('tenant', 'tenant_code');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_messaging_templates', function($table)
        {
            $table->renameColumn('tenant_code', 'tenant');
        });
    }
}
