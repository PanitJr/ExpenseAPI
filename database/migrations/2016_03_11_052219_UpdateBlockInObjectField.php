<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlockInObjectField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("object_field",function(Blueprint $table){
            $table->integer('blockid')->unsigned()->nullable();
            $table->index('blockid');
            $table->foreign('blockid')->references('id')->on('object_block')->onDelete('SET NULL'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("object_field",function(Blueprint $table){
            $table->dropForeign('object_field_blockid_foreign');
            $table->dropColumn('blockid');
        });
    }
}
