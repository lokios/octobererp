<?php namespace Olabs\Estore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsEstoreProducts3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_estore_products', function($table)
        {
            $table->dateTime('release_date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_estore_products', function($table)
        {
            $table->dropColumn('release_date');
        });
    }
}
