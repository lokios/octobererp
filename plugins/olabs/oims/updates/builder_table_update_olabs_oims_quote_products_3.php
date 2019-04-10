<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuoteProducts3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quote_products', function($table)
        {
            $table->integer('tax_id')->nullable();
            $table->string('tax_code')->nullable();
            $table->decimal('pre_tax_retail_price', 12, 2)->nullable();
            $table->decimal('retail_price_with_tax', 12, 2)->nullable();
            $table->decimal('total_tax', 12, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quote_products', function($table)
        {
            $table->dropColumn('tax_id');
            $table->dropColumn('tax_code');
            $table->dropColumn('pre_tax_retail_price');
            $table->dropColumn('retail_price_with_tax');
            $table->dropColumn('total_tax');
        });
    }
}
