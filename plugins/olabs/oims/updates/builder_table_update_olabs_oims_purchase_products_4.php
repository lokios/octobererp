<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchaseProducts4 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchase_products', function($table)
        {
            $table->decimal('pre_tax_retail_price', 12, 2)->nullable();
            $table->string('tax_code')->nullable();
            $table->integer('tax_id')->nullable();
            $table->decimal('tax_percent', 12, 2)->nullable();
            $table->decimal('total_tax', 12, 2)->nullable();
            $table->text('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchase_products', function($table)
        {
            $table->dropColumn('pre_tax_retail_price');
            $table->dropColumn('tax_code');
            $table->dropColumn('tax_id');
            $table->dropColumn('tax_percent');
            $table->dropColumn('total_tax');
            $table->dropColumn('description');
        });
    }
}
