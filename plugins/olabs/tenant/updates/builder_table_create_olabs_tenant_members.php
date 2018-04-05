<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsTenantMembers extends Migration
{
    public function up()
    {
        Schema::create('olabs_tenant_members', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->text('group_id');
            $table->string('status', 10);
            $table->integer('org_id');
            $table->string('app_id', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_tenant_members');
    }
}
