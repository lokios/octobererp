<?php namespace Olabs\Estore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsEstoreProducts6 extends Migration
{
    public function up()
    {
        Schema::table('olabs_estore_products', function($table)
        {
            $table->decimal('sale_price', 10, 2)->change();
            $table->decimal('cost_price', 10, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_estore_products', function($table)
        {
            $table->decimal('sale_price', 10, 0)->change();
            $table->decimal('cost_price', 10, 0)->change();
        });
    }
}
