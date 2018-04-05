<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantOrganizations3 extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_organizations', function($table)
        {
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->text('phone_1')->nullable();
            $table->text('phone_2')->nullable();
            $table->text('website')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_organizations', function($table)
        {
            $table->dropColumn('email');
            $table->dropColumn('fax');
            $table->dropColumn('phone_1');
            $table->dropColumn('phone_2');
            $table->dropColumn('website');
        });
    }
}
