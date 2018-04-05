<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Update111 extends Migration
{

    public function up()
    {
        Schema::table('olabs_oims_orders', function ($table) {
            $table->text('note')->nullable();
            $table->string("ds_county")->nullable();
            $table->string("is_county")->nullable();
        });
    }

    public function down()
    {
        Schema::table('olabs_oims_orders', function ($table) {
            $table->dropColumn('note');
            $table->dropColumn('ds_county');
            $table->dropColumn('is_county');
        });
    }

}
