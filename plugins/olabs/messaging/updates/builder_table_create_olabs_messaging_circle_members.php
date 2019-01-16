<?php namespace Olabs\Messaging\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsMessagingCircleMembers extends Migration
{
    public function up()
    {
        Schema::create('olabs_messaging_circle_members', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('circle_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_messaging_circle_members');
    }
}
