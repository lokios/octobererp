<?php namespace Olabs\Tenant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsTenantContents extends Migration
{
    public function up()
    {
        Schema::table('olabs_tenant_contents', function($table)
        {
            $table->text('cover_photo')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_tenant_contents', function($table)
        {
            $table->dropColumn('cover_photo');
        });
    }
}
