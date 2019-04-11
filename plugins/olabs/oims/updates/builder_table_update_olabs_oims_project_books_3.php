<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectBooks3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_books', function($table)
        {
            $table->renameColumn('balance_leaf', 'leaf_balance');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_books', function($table)
        {
            $table->renameColumn('leaf_balance', 'balance_leaf');
        });
    }
}
