<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsOimsUserProjects extends Migration
{
    public function up()
    {
        Schema::create('olabs_oims_user_projects', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->integer('project_id');
            $table->primary(['user_id','project_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_oims_user_projects');
    }
}
