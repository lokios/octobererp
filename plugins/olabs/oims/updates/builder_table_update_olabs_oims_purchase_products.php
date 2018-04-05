<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchaseProducts extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchase_products', function($table)
        {
            $table->string('unit')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchase_products', function($table)
        {
            $table->dropColumn('unit');
        });
    }
}
