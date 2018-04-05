<?php namespace Olabs\Iot\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsIotAwsMessage extends Migration
{
    public function up()
    {
        Schema::create('olabs_iot_aws_message', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('request_type')->nullable();
            $table->text('message')->nullable();
            $table->string('station_phone')->nullable();
            $table->text('meta')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_iot_aws_message');
    }
}
