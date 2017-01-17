<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldObjetModelToUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('objects_model')) {
            Schema::table('objects_model', function ($table) {
                $table->unique('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objects_model', function ($table) {
            $table->dropUnique('objects_model_name_unique');
        }); 
    }
}
