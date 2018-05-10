<?php namespace Olabs\Oims\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOlabsOimsProjectBooks extends Migration
{
    public function up()
    {
        Schema::table('olabs_oims_project_books', function($table)
        {
            $table->renameColumn('type', 'book_type');
        });
    }
    
    public function down()
    {
        Schema::table('olabs_oims_project_books', function($table)
        {
            $table->renameColumn('book_type', 'type');
        });
    }
}
