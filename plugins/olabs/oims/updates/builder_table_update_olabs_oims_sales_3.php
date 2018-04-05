<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsSales3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_sales', function($table)
        {
            $table->dateTime('context_date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_sales', function($table)
        {
            $table->dropColumn('context_date');
        });
    }
}
