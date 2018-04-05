<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateBrandsTable extends Migration
{

    public function up()
    {
        Schema::create('olabs_oims_brands', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->nullable();
            $table->boolean('show_in_menu')->nullable();            
            
            // meta info
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();            
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('olabs_oims_brands');
    }

}
