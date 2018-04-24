<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSocialEntityRelations2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_social_entity_relations', function($table)
        {
            $table->string('target_id', 10)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_social_entity_relations', function($table)
        {
            $table->integer('target_id')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
