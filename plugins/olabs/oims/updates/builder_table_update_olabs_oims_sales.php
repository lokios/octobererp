<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsSales extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_sales', function($table)
        {
            $table->string('status', 255)->nullable();
            $table->string('reference_number')->nullable();
            $table->renameColumn('status_id', 'context_date');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_sales', function($table)
        {
            $table->dropColumn('status');
            $table->dropColumn('reference_number');
            $table->renameColumn('context_date', 'status_id');
        });
    }
}
