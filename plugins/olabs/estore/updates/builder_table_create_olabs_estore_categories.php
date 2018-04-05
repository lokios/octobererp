<?php namespace Olabs\Estore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsEstoreCategories extends Migration
{
    public function up()
    {
        Schema::create('olabs_estore_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->string('name', 255);
            $table->text('slug');
            $table->integer('tenant_id');
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_estore_categories');
    }
}
