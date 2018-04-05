<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProducts2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_products', function($table)
        {
            $table->decimal('pre_tax_wholesale_price', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('pre_tax_retail_price', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('retail_price_with_tax', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('package_width', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('package_height', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('package_depth', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('package_weight', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('additional_shipping_fees', 12, 2)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_products', function($table)
        {
            $table->double('pre_tax_wholesale_price', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('pre_tax_retail_price', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('retail_price_with_tax', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('package_width', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('package_height', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('package_depth', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('package_weight', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('additional_shipping_fees', 10, 0)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
