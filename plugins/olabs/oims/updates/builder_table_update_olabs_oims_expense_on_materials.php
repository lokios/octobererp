<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsExpenseOnMaterials extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_expense_on_materials', function($table)
        {
            $table->decimal('total_price_without_tax', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('total_tax', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('total_price', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('shipping_price_without_tax', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('shipping_tax', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('shipping_price', 12, 2)->nullable()->unsigned(false)->default(null)->change();
            $table->decimal('total_global_discount', 12, 2)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_expense_on_materials', function($table)
        {
            $table->double('total_price_without_tax', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('total_tax', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('total_price', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('shipping_price_without_tax', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('shipping_tax', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('shipping_price', 10, 0)->nullable()->unsigned(false)->default(null)->change();
            $table->double('total_global_discount', 10, 0)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
