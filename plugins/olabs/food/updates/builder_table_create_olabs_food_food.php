<?php namespace Olabs\Food\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsFoodFood extends Migration
{
    public function up()
    {
        Schema::create('olabs_food_food', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->text('photo')->nullable();
            $table->dateTime('date_created')->nullable();
            $table->dateTime('date_updated')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_food_food');
    }
}
