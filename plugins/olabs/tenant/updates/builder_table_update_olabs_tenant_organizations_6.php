<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantOrganizations6 extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_organizations', function($table)
        {
            $table->string('profile_type', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_organizations', function($table)
        {
            $table->dropColumn('profile_type');
        });
    }
}
