<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreaetTebleObjectModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'objects_model'
            ,function(Blueprint $table)
            {
                $table->increments("id");
                $table->string("name");
                $table->string("tablename");
                $table->string("fieldname");
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('objects_model');
    }
}
