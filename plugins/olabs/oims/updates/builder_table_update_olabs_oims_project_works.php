<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectWorks extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->decimal('unit_price', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('quantity', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('total_amount', 12, 2)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_works', function($table)
        {
            $table->double('unit_price', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('quantity', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('total_amount', 10, 0)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
