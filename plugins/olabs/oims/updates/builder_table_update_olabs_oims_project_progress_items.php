<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectProgressItems extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_progress_items', function($table)
        {
            $table->decimal('quantity', 10, 4)->change();
            $table->decimal('unit_price', 10, 4)->change();
            $table->decimal('total_price', 10, 4)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_progress_items', function($table)
        {
            $table->decimal('quantity', 10, 0)->change();
            $table->decimal('unit_price', 10, 0)->change();
            $table->decimal('total_price', 10, 0)->change();
        });
    }
}
