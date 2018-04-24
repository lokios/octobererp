<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSocialEntityRelations extends Migration
{
    public function up()
    {
        Schema::table('olabs_social_entity_relations', function($table)
        {
            $table->string('request_id', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_social_entity_relations', function($table)
        {
            $table->dropColumn('request_id');
        });
    }
}
