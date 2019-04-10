<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuoteProducts4 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quote_products', function($table)
        {
            $table->renameColumn('retail_price_with_tax', 'tax_percent');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quote_products', function($table)
        {
            $table->renameColumn('tax_percent', 'retail_price_with_tax');
        });
    }
}
