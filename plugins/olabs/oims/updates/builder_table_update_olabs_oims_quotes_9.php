<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuotes9 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->text('subject')->nullable();
            $table->string('loading')->nullable();
            $table->string('freight')->nullable();
            $table->decimal('tax_igst', 10, 0)->nullable();
            $table->decimal('tax_cgst', 10, 0)->nullable();
            $table->decimal('tax_sgst', 10, 0)->nullable();
            $table->string('form_c')->nullable();
            $table->string('guaranty')->nullable();
            $table->text('payment_terms')->nullable();
            $table->text('terms_condition')->nullable();
            $table->decimal('tax_igst_amount', 10, 0)->nullable();
            $table->decimal('tax_cgst_amount', 10, 0)->nullable();
            $table->decimal('tax_sgst_amount', 10, 0)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->dropColumn('subject');
            $table->dropColumn('loading');
            $table->dropColumn('freight');
            $table->dropColumn('tax_igst');
            $table->dropColumn('tax_cgst');
            $table->dropColumn('tax_sgst');
            $table->dropColumn('form_c');
            $table->dropColumn('guaranty');
            $table->dropColumn('payment_terms');
            $table->dropColumn('terms_condition');
            $table->dropColumn('tax_igst_amount');
            $table->dropColumn('tax_cgst_amount');
            $table->dropColumn('tax_sgst_amount');
        });
    }
}
