<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsOffroleEmployees6 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->decimal('daily_wages', 12, 2)->change();
            $table->decimal('monthly_wages', 12, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->decimal('daily_wages', 10, 0)->change();
            $table->decimal('monthly_wages', 10, 0)->change();
        });
    }
}
