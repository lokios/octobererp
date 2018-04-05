<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsQuotes14 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->decimal('tax_igst', 10, 2)->change();
            $table->decimal('tax_cgst', 10, 2)->change();
            $table->decimal('tax_sgst', 10, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_quotes', function($table)
        {
            $table->decimal('tax_igst', 10, 0)->change();
            $table->decimal('tax_cgst', 10, 0)->change();
            $table->decimal('tax_sgst', 10, 0)->change();
        });
    }
}
