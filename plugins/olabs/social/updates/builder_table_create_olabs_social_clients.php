<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsSocialClients extends Migration
{
    public function up()
    {
        Schema::create('olabs_social_clients', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->string('code', 255);
            $table->string('secret', 255)->nullable();
            $table->string('key', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('status', 25)->nullable()->default('L');
            $table->string('billing_plan', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('customer_email', 255)->nullable();
            $table->string('customer_phone', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_social_clients');
    }
}
