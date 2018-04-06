<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsSocialClientsBilling extends Migration
{
    public function up()
    {
        Schema::create('olabs_social_clients_billing', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('clients_id')->nullable();
            $table->dateTime('month');
            $table->integer('sms_count')->nullable()->default(0);
            $table->integer('email_count')->nullable()->default(0);
            $table->decimal('sms_total', 11, 2)->nullable()->default(0);
            $table->decimal('email_total', 11, 2)->nullable()->default(0);
            $table->integer('push_count')->nullable()->default(0);
            $table->string('payment_status', 255)->nullable()->default('NEW');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->decimal('total_amout', 11, 2)->nullable()->default(0);
            $table->decimal('net_amount', 11, 2)->nullable()->default(0);
            $table->text('note')->nullable();
            $table->integer('created_by')->nullable()->default(0);
            $table->string('payment_mode', 255)->nullable();
            $table->text('payment_info')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_social_clients_billing');
    }
}
