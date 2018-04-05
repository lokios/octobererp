<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProductsUsersPrice extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_products_users_price', function($table)
        {
            $table->decimal('price', 12, 2)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_products_users_price', function($table)
        {
            $table->double('price', 10, 0)->nullable(false)->unsigned()->default(null)->change();
        });
    }
}
