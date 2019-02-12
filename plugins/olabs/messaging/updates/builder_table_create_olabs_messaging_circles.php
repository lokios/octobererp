<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsMessagingCircles extends Migration
{
    public function up()
    {
        Schema::create('olabs_messaging_circles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->string('status')->nullable();
            $table->string('tenant_code')->nullable();
            $table->text('descriptions')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_messaging_circles');
    }
}
