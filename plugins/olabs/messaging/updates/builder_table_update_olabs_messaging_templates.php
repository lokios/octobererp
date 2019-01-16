<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsMessagingTemplates extends Migration
{
    public function up()
    {
        Schema::table('olabs_messaging_templates', function($table)
        {
            $table->text('descriptions')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_messaging_templates', function($table)
        {
            $table->dropColumn('descriptions');
        });
    }
}
