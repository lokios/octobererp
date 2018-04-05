<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Update114 extends Migration
{

    public function up()
    {
        Schema::table('olabs_oims_orders', function ($table) {
            $table->string("tracking_number")->nullable();
        });
    }

    public function down()
    {
        Schema::table('olabs_oims_orders', function ($table) {
            $table->dropColumn('tracking_number');
        });
    }

}
