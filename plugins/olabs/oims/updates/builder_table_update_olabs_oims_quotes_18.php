<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuotes18 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->integer('tax_cgst')->nullable()->unsigned(false)->default(null)->change();
            $table->integer('tax_igst')->nullable()->unsigned(false)->default(null)->change();
            $table->integer('tax_sgst')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->decimal('tax_cgst', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('tax_igst', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('tax_sgst', 12, 2)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
