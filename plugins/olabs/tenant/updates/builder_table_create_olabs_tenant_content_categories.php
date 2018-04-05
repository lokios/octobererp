<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsTenantContentCategories extends Migration
{
    public function up()
    {
        Schema::create('olabs_tenant_content_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->text('code');
            $table->text('label');
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_tenant_content_categories');
    }
}
