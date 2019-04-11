<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchases6 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->integer('tax_cgst')->nullable()->change();
            $table->decimal('tax_cgst_amount', 12, 2)->nullable()->change();
            $table->integer('tax_igst')->nullable()->change();
            $table->decimal('tax_igst_amount', 12, 2)->nullable()->change();
            $table->integer('tax_sgst')->nullable()->change();
            $table->decimal('tax_sgst_amount', 12, 2)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->integer('tax_cgst')->nullable(false)->change();
            $table->decimal('tax_cgst_amount', 12, 2)->nullable(false)->change();
            $table->integer('tax_igst')->nullable(false)->change();
            $table->decimal('tax_igst_amount', 12, 2)->nullable(false)->change();
            $table->integer('tax_sgst')->nullable(false)->change();
            $table->decimal('tax_sgst_amount', 12, 2)->nullable(false)->change();
        });
    }
}
