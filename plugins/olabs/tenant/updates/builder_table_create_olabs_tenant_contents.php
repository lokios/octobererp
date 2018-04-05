<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsTenantContents extends Migration
{
    public function up()
    {
        Schema::create('olabs_tenant_contents', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('name');
            $table->text('type')->nullable();
            $table->string('status', 100)->nullable();
            $table->integer('tenant_id')->nullable();
            $table->text('tags')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('content')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_tenant_contents');
    }
}
