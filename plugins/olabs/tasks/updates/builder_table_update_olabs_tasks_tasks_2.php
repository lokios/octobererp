<?php namespace Olabs\Tasks\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTasksTasks2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_tasks_tasks', function($table)
        {
            $table->string('attachment_input1_name', 255)->nullable();
            $table->string('attachment_input2_name', 255)->nullable();
            $table->string('attachment_input3_name', 255)->nullable();
            $table->string('attachment_input4_name', 255)->nullable();
        });
    }
    
    public function down()
    { return;
        Schema::table('olabs_tasks_tasks', function($table)
        {
            $table->dropColumn('attachment_input1_name');
            $table->dropColumn('attachment_input2_name');
            $table->dropColumn('attachment_input3_name');
            $table->dropColumn('attachment_input4_name');
        });
    }
}
