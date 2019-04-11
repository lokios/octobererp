<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectBooks2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_books', function($table)
        {
            $table->integer('leaf_count')->nullable();
            $table->integer('balance_leaf')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_books', function($table)
        {
            $table->dropColumn('leaf_count');
            $table->dropColumn('balance_leaf');
        });
    }
}
