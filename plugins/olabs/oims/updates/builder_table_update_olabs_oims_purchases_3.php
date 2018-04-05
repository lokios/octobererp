<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsPurchases3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->integer('quote_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_purchases', function($table)
        {
            $table->dropColumn('quote_id');
        });
    }
}
