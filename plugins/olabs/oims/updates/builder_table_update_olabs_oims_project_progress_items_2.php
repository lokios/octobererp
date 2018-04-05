<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectProgressItems2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_progress_items', function($table)
        {
            $table->decimal('unit_price', 10, 2)->change();
            $table->decimal('total_price', 10, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_progress_items', function($table)
        {
            $table->decimal('unit_price', 10, 4)->change();
            $table->decimal('total_price', 10, 4)->change();
        });
    }
}
