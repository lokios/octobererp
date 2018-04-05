<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectProgress2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_progress', function($table)
        {
            $table->decimal('total_price', 12, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_progress', function($table)
        {
            $table->dropColumn('total_price');
        });
    }
}
