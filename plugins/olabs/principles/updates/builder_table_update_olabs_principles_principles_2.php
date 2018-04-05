<?php namespace Olabs\Principles\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsPrinciplesPrinciples2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_principles_principles', function($table)
        {
            $table->integer('category')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_principles_principles', function($table)
        {
            $table->dropColumn('category');
        });
    }
}
