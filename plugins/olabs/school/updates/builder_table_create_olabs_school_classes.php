<?php namespace Olabs\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsSchoolClasses extends Migration
{
    public function up()
    {
        Schema::create('olabs_school_classes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->text('status')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('tenant_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_school_classes');
    }
}
