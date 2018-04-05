<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePropertiesTable extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_properties', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            $table->string('title')->nullable();
            $table->string('placeholder')->nullable();
            $table->integer('type')->nullable();
            $table->boolean('required')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_properties');
    }

}
