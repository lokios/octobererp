<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsVouchers extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_vouchers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->string('status');
            $table->decimal('total_price', 12, 2);
            $table->dateTime('paid_date');
            $table->text('paid_detail');
            $table->integer('payment_method');
            $table->text('description');
            $table->integer('project_id');
            $table->string('reference_number');
            $table->dateTime('context_date');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('payment_type');
            $table->string('narration');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_vouchers');
    }
}
