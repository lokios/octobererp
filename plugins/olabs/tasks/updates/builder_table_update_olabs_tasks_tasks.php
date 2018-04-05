<?php namespace Olabs\Tasks\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTasksTasks extends Migration
{
    public function up()
    {
        Schema::table('olabs_tasks_tasks', function($table)
        {
            $table->text('email_from')->nullable();
        });
    }
    
    public function down()
    {
        return;
        Schema::table('olabs_tasks_tasks', function($table)
        {
            $table->dropColumn('email_from');
        });
    }
}
