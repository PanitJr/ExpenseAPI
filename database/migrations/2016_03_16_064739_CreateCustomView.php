<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customview',function(Blueprint $table){
            $table->increments('id');
            $table->string('viewname');
            $table->boolean('setdefault');
            $table->integer('objectid')->unsigned();  
            $table->foreign('objectid')->references('id')
                    ->on('objects_model')->onDelete('cascade'); 
            $table->integer('userid')->nullable();
        });

        Schema::create('customview_columnslist',function(Blueprint $table){
            $table->increments('id');
            $table->integer('cvid')->unsigned();  
            $table->foreign('cvid')->references('id')
                    ->on('customview')->onDelete('cascade');
            $table->integer('columnindex');
            $table->string('columnname'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customview_columnslist');
        Schema::drop('customview');
    }
}
