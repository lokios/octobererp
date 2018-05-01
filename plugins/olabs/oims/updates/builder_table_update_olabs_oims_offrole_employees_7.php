<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsOffroleEmployees7 extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_offrole_employees', function($table)
        {
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone');
            $table->dropColumn('address');
            $table->dropColumn('address_2');
            $table->dropColumn('postcode');
            $table->dropColumn('city');
            $table->dropColumn('country');
        });
    }
}
