<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsMessagingTemplates2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_messaging_templates', function($table)
        {
            $table->string('tenant')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_messaging_templates', function($table)
        {
            $table->dropColumn('tenant');
        });
    }
}
