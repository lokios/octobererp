<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProductsOptions extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_products_options', function($table)
        {
            $table->decimal('price_difference_with_tax', 12, 2)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_products_options', function($table)
        {
            $table->double('price_difference_with_tax', 10, 0)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
