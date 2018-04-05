<?php namespace Olabs\Pusher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsPusherActivity extends Migration
{
    public function up()
    {
        Schema::table('olabs_pusher_activity', function($table)
        {
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->integer('retries')->nullable();
            $table->dateTime('published_date')->nullable();
            $table->integer('author_id')->nullable();
            $table->text('extra')->nullable();
            $table->bigIncrements('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_pusher_activity', function($table)
        {
            $table->dropColumn('publish_date');
            $table->dropColumn('expiry_date');
            $table->dropColumn('retries');
            $table->dropColumn('published_date');
            $table->dropColumn('author_id');
            $table->dropColumn('extra');
            $table->bigIncrements('id')->unsigned()->change();
        });
    }
}
