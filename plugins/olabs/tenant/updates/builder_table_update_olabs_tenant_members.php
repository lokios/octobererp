<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantMembers extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_members', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_members', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}
