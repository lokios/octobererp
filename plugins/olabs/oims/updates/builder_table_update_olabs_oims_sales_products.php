<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsSalesProducts extends Migration
{
    public function up()
    {
        Schema::rename('olabs_oims_sale_products', 'olabs_oims_sales_products');
        Schema::table('olabs_oims_sales_products', function($table)
        {
            $table->renameColumn('purchase_id', 'sales_id');
        });
    }
    
    public function down()
    {
        Schema::rename('olabs_oims_sales_products', 'olabs_oims_sale_products');
        Schema::table('olabs_oims_sale_products', function($table)
        {
            $table->renameColumn('sales_id', 'purchase_id');
        });
    }
}
