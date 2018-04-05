<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsTenantContentsCategories extends Migration
{
    public function up()
    {
        Schema::create('olabs_tenant_contents_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('contents_categories_id');
            $table->integer('contents_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_tenant_contents_categories');
    }
}
