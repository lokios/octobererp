<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantMembers2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_members', function($table)
        {
            $table->string('group_type')->nullable();
            $table->string('circle')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_members', function($table)
        {
            $table->dropColumn('group_type');
            $table->dropColumn('circle');
        });
    }
}
