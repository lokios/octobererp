<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchases8 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->integer('vehicle_id')->nullable();
            $table->text('vehicle_meta')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->dropColumn('vehicle_id');
            $table->dropColumn('vehicle_meta');
        });
    }
}
