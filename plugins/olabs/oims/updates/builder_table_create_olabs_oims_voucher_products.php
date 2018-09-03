<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsVoucherProducts extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_voucher_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('voucher_id')->nullable();
            $table->integer('purchase_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->text('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_voucher_products');
    }
}
