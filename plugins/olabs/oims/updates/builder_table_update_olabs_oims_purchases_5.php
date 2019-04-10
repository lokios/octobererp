<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchases5 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->integer('tax_cgst');
            $table->decimal('tax_cgst_amount', 12, 2);
            $table->integer('tax_igst');
            $table->integer('tax_sgst');
            $table->decimal('tax_igst_amount', 12, 2);
            $table->decimal('tax_sgst_amount', 12, 2);
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->dropColumn('tax_cgst');
            $table->dropColumn('tax_cgst_amount');
            $table->dropColumn('tax_igst');
            $table->dropColumn('tax_sgst');
            $table->dropColumn('tax_igst_amount');
            $table->dropColumn('tax_sgst_amount');
        });
    }
}
