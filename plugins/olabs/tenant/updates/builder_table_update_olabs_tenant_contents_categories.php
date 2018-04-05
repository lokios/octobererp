<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantContentsCategories extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_contents_categories', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->renameColumn('contents_categories_id', 'content_categories_id');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_contents_categories', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->renameColumn('content_categories_id', 'contents_categories_id');
        });
    }
}
