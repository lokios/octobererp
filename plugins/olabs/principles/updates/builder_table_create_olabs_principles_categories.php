<?php namespace Olabs\Principles\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsPrinciplesCategories extends Migration
{
    public function up()
    {
        Schema::create('olabs_principles_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('title');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_principles_categories');
    }
}
