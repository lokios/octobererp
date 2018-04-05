<?php namespace Olabs\Estore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsEstoreProducts5 extends Migration
{
    public function up()
    {
        Schema::table('olabs_estore_products', function($table)
        {
            $table->integer('source_stock')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_estore_products', function($table)
        {
            $table->dropColumn('source_stock');
        });
    }
}
