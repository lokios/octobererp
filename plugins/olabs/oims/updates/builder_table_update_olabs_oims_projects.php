<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjects extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->string('address_2')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_person')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_projects', function($table)
        {
            $table->dropColumn('address_2');
            $table->dropColumn('postcode');
            $table->dropColumn('city');
            $table->dropColumn('country');
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_person');
        });
    }
}
