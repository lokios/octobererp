<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsSocialNotifications extends Migration
{
    public function up()
    {
        Schema::table('olabs_social_notifications', function($table)
        {
            $table->text('peer_tenant_info')->nullable();
            $table->text('peer_branch_info')->nullable();
            $table->string('entity_type')->nullable();
            $table->integer('entity_id')->nullable();
            $table->string('notification_type')->nullable();
            $table->integer('target_id')->nullable();
            $table->string('target_type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('olabs_social_notifications', function($table)
        {
            $table->dropColumn('peer_tenant_info');
            $table->dropColumn('peer_branch_info');
            $table->dropColumn('entity_type');
            $table->dropColumn('entity_id');
            $table->dropColumn('notification_type');
            $table->dropColumn('target_id');
            $table->dropColumn('target_type');
        });
    }
}
