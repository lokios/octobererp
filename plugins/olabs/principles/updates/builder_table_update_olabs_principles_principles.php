<?php namespace Olabs\Principles\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsPrinciplesPrinciples extends Migration
{
    public function up()
    {
        Schema::rename('olabs_principles_', 'olabs_principles_principles');
    }
    
    public function down()
    {
        Schema::rename('olabs_principles_principles', 'olabs_principles_');
    }
}
