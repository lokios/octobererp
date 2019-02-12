<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsMessagingTemplates4 extends Migration
{
    public function up()
    {
        Schema::table('olabs_messaging_templates', function($table)
        {
            $table->text('web_push_template')->nullable();
            $table->text('mobile_push_template')->nullable();
            $table->dropColumn('iam_template');
            $table->dropColumn('device_template');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_messaging_templates', function($table)
        {
            $table->dropColumn('web_push_template');
            $table->dropColumn('mobile_push_template');
            $table->text('iam_template')->nullable();
            $table->text('device_template')->nullable();
        });
    }
}
