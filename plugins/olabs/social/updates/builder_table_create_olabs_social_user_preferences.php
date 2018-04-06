<?php namespace Olabs\Social\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOlabsSocialUserPreferences extends Migration
{
    public function up()
    {
        Schema::create('olabs_social_user_preferences', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('app_id', 11);
            $table->integer('user_id');
            $table->string('user_info', 255)->nullable();
            $table->text('android_reg_id')->nullable();
            $table->string('android_not_preference', 12)->nullable()->default('Y');
            $table->text('ios_reg_id')->nullable();
            $table->string('ios_not_prefrence', 12)->nullable()->default('Y');
            $table->string('sms_preference')->nullable()->default('Y');
            $table->string('email_preference')->nullable()->default('Y');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('cell', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('olabs_social_user_preferences');
    }
}
