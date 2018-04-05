<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuotes2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->text('note')->nullable();
            $table->string('ds_county')->nullable();
            $table->string('is_county')->nullable();
            $table->string('tracking_number')->nullable();
            $table->double('total_global_discount', 10, 0)->nullable();
            $table->integer('coupon_id')->nullable();
            $table->integer('payment_gateway_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->dropColumn('note');
            $table->dropColumn('ds_county');
            $table->dropColumn('is_county');
            $table->dropColumn('tracking_number');
            $table->dropColumn('total_global_discount');
            $table->dropColumn('coupon_id');
            $table->dropColumn('payment_gateway_id');
        });
    }
}
