<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchaseProducts2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchase_products', function($table)
        {
            $table->integer('quote_product_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchase_products', function($table)
        {
            $table->dropColumn('quote_product_id');
        });
    }
}
