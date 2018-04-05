<?php namespace Olabs\Principles\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsPrinciples extends Migration
{
    public function up()
    {
        Schema::create('olabs_principles_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('title')->nullable();
            $table->text('explanation')->nullable();
            $table->text('credit')->nullable();
            $table->text('discredit')->nullable();
            $table->text('support')->nullable();
            $table->dateTime('date_created')->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->text('status')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_principles_');
    }
}
