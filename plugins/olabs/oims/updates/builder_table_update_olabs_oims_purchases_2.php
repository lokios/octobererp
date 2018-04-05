<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchases2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->string('bill_number', 255)->nullable();
            $table->date('bill_date')->nullable();
            $table->string('thru_vehicle_number', 255)->nullable();
            $table->date('arrived_on_date')->nullable();
            $table->string('driver_name', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->dropColumn('bill_number');
            $table->dropColumn('bill_date');
            $table->dropColumn('thru_vehicle_number');
            $table->dropColumn('arrived_on_date');
            $table->dropColumn('driver_name');
        });
    }
}
