<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsPaymentReceivables extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_payment_receivables', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('project_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->decimal('amount', 10, 0)->nullable();
            $table->string('reference_number')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('context_date')->nullable();
            $table->text('note')->nullable();
            $table->string('payment_method')->nullable();
            $table->dateTime('paid_date')->nullable();
            $table->text('paid_detail')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_payment_receivables');
    }
}
