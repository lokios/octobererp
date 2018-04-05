<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsMachineryProducts extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_machinery_products', function($table)
        {
            $table->decimal('unit_price', 12, 2)->change();
            $table->decimal('quantity', 12, 2)->change();
            $table->decimal('total_price', 12, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_machinery_products', function($table)
        {
            $table->decimal('unit_price', 10, 0)->change();
            $table->decimal('quantity', 10, 0)->change();
            $table->decimal('total_price', 10, 0)->change();
        });
    }
}
