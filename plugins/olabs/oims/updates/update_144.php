<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Update_144 extends Migration
{

    public function up()
    {
        Schema::table('olabs_oims_brands', function ($table) {
            $table->text("short_description")->nullable();
        });
    }

    public function down()
    {
        Schema::table('olabs_oims_brands', function ($table) {
            $table->dropColumn('short_description');
        });
    }

}
