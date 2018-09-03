<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsVouchers extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_vouchers', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->integer('user_id')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->decimal('total_price', 12, 2)->nullable()->change();
            $table->dateTime('paid_date')->nullable()->change();
            $table->text('paid_detail')->nullable()->change();
            $table->integer('payment_method')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->integer('project_id')->nullable()->change();
            $table->string('reference_number')->nullable()->change();
            $table->dateTime('context_date')->nullable()->change();
            $table->integer('created_by')->nullable()->change();
            $table->integer('updated_by')->nullable()->change();
            $table->string('payment_type')->nullable()->change();
            $table->string('narration')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_vouchers', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->integer('user_id')->nullable(false)->change();
            $table->string('status', 255)->nullable(false)->change();
            $table->decimal('total_price', 12, 2)->nullable(false)->change();
            $table->dateTime('paid_date')->nullable(false)->change();
            $table->text('paid_detail')->nullable(false)->change();
            $table->integer('payment_method')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->integer('project_id')->nullable(false)->change();
            $table->string('reference_number', 255)->nullable(false)->change();
            $table->dateTime('context_date')->nullable(false)->change();
            $table->integer('created_by')->nullable(false)->change();
            $table->integer('updated_by')->nullable(false)->change();
            $table->string('payment_type', 255)->nullable(false)->change();
            $table->string('narration', 255)->nullable(false)->change();
        });
    }
}
