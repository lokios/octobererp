<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_coupons', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            $table->boolean('active')->nullable(); // active
            $table->string('code')->nullable(); // coupon code
            
            // date limitation
            $table->timestamp('valid_from')->nullable(); 
            $table->timestamp('valid_to')->nullable();
            
            $table->integer('count')->nullable(); // count limitation
            $table->integer('used_count')->nullable();
            
            $table->double('minimum_value_basket')->nullable();
            
            $table->integer('type_value')->nullable(); // 0-percent, 1-money
            $table->double('value')->nullable(); // value
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_coupons');
    }
}
