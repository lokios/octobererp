<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsUnits extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_units', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->renameColumn('code', 'slug');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_units', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->renameColumn('slug', 'code');
        });
    }
}
