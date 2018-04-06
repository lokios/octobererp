<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsSocialEntityRelations extends Migration
{
    public function up()
    {
        Schema::create('olabs_social_entity_relations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tenant_id')->nullable();
            $table->integer('actor_id')->nullable();
            $table->string('actor_name', 255)->nullable();
            $table->string('actor_email', 255)->nullable();
            $table->string('relation', 255)->nullable();
            $table->string('target_type', 255)->nullable();
            $table->integer('target_id')->nullable();
            $table->string('context_type', 255)->nullable();
            $table->string('context_id', 255)->nullable();
            $table->text('data')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('status', 255)->nullable();
            $table->string('relation_status', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_social_entity_relations');
    }
}
