<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePaymentGatewaysTable extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_payment_gateways', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            // Order status - before payment
            $table->integer('order_status_before_id')->unsigned()->nullable();
            $table->foreign('order_status_before_id')->references('id')->on('olabs_oims_order_statuses')->onDelete('set null');
            
            // Order status - after payment
            $table->integer('order_status_after_id')->unsigned()->nullable();
            $table->foreign('order_status_after_id')->references('id')->on('olabs_oims_order_statuses')->onDelete('set null');
            
            // Active
            $table->boolean('active')->nullable();
            
            // Gateway
            $table->string('gateway',100)->nullable();
            $table->string('gateway_title',255)->nullable();
            $table->string('gateway_currency',20)->nullable();
            $table->string('payment_page',255)->nullable();
            
            // parameters
            $table->text('parameters')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_payment_gateways');
    }
}
