<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantOrganizations5 extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_organizations', function($table)
        {
            $table->text('map')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_organizations', function($table)
        {
            $table->dropColumn('map');
        });
    }
}
