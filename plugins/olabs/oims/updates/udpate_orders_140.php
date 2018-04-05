<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UdpateOrders140 extends Migration
{

    public function up()
    {
        Schema::table('olabs_oims_orders', function ($table) {
            $table->double("total_global_discount")->nullable();
            
            $table->integer('coupon_id')->unsigned()->nullable();
            $table->foreign('coupon_id')->references('id')->on('olabs_oims_coupons')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('olabs_oims_orders', function ($table) {
            $table->dropForeign('olabs_oims_orders_coupon_id_foreign');
            
            $table->dropColumn('total_global_discount');
            $table->dropColumn('coupon_id');
        });
    }

}
