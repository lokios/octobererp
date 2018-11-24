<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectWorks5 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->decimal('products_total_price', 12, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->dropColumn('products_total_price');
        });
    }
}
