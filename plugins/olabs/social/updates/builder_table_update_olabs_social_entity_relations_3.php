<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSocialEntityRelations3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_social_entity_relations', function($table)
        {
            $table->text('descriptions')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_social_entity_relations', function($table)
        {
            $table->dropColumn('descriptions');
        });
    }
}
