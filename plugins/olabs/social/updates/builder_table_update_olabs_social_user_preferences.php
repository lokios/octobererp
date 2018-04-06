<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSocialUserPreferences extends Migration
{
    public function up()
    {
        Schema::table('olabs_social_user_preferences', function($table)
        {
            $table->text('preferences')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_social_user_preferences', function($table)
        {
            $table->dropColumn('preferences');
            $table->increments('id')->unsigned()->change();
        });
    }
}
