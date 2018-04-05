<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchases extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->string('status', 255)->nullable();
            $table->string('reference_number')->nullable();
            $table->dateTime('context_date')->nullable();
            $table->dropColumn('status_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->dropColumn('status');
            $table->dropColumn('reference_number');
            $table->dropColumn('context_date');
            $table->integer('status_id')->nullable();
        });
    }
}
