<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTaxesTable extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_taxes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            $table->string('name')->nullable();
            $table->boolean('active')->nullable();
            $table->double('percent')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_taxes');
    }

}
