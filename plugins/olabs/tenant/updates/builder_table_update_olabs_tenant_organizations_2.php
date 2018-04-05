<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantOrganizations2 extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_organizations', function($table)
        {
            $table->text('description')->nullable()->change();
            $table->text('address_1')->nullable()->change();
            $table->string('address_2')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->text('country')->nullable()->change();
            $table->text('zip')->nullable()->change();
            $table->text('headline')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_organizations', function($table)
        {
            $table->text('description')->nullable(false)->change();
            $table->text('address_1')->nullable(false)->change();
            $table->string('address_2', 255)->nullable(false)->change();
            $table->string('city', 255)->nullable(false)->change();
            $table->string('state', 255)->nullable(false)->change();
            $table->text('country')->nullable(false)->change();
            $table->text('zip')->nullable(false)->change();
            $table->text('headline')->nullable(false)->change();
        });
    }
}
