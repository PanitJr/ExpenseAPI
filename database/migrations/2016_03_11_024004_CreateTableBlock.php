<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("object_block",function(Blueprint $table){
            $table->increments('id');
            $table->integer('objectid')->unsigned();
            $table->string('blocklabel');
            $table->integer('sequence');
            $table->foreign('objectid')->references('id')->on('objects_model')->onDelete('cascade'); 
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::drop('object_block');
    }
}
