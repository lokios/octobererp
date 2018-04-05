<?php namespace Olabs\Estore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsEstoreProducts extends Migration
{
    public function up()
    {
        Schema::table('olabs_estore_products', function($table)
        {
            $table->decimal('source_price', 10, 0)->nullable();
            $table->text('source_currency')->nullable();
            $table->text('languages')->nullable();
            $table->text('regions')->nullable();
            $table->bigIncrements('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_estore_products', function($table)
        {
            $table->dropColumn('source_price');
            $table->dropColumn('source_currency');
            $table->dropColumn('languages');
            $table->dropColumn('regions');
            $table->bigIncrements('id')->unsigned()->change();
        });
    }
}
