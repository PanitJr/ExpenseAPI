<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateObjectFieldForFieldType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("object_field_type",function(Blueprint $table){
            $table->increments('id');
            $table->string('fieldtype');
        });

       Schema::table("object_field",function(Blueprint $table){
            $table->integer('type')->unsigned()->nullable();
            $table->index('type');
            $table->foreign('type')->references('id')->on('object_field_type')->onDelete('SET NULL'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('object_field_type');
    }
}
