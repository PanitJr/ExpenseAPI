<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountObject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('objects_model')->insert(
            [
                'id'=>1,
                'name' => 'Accounts', 
                'tablename' => 'cc_accounts', 
                'fieldname' => 'accountname'
            ]
        );

        DB::table('object_block')->insert(
            [
                'id'=>1,
                'objectid' => 1, 
                'blocklabel' => 'Accounts Information',
                'sequence'=>1
            ]
        );

        DB::table('object_field')->insert(
            [
                'id'=>1,
                'objectid' => 1, 
                'blockid' => 1,
                'sequence'=>1,
                'fieldname'=>"accountname",
                'fieldlabel'=>"Account Name"
            ]
        );
        Schema::create('cc_accounts',function($table){
            $table->integer('id');
            $table->string("accountname");
            $table->primary('id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('objects_model')->where('name', 'Accounts')->delete();
        Schema::drop('cc_accounts');
    }
}
