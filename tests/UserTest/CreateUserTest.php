<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;


class CreateUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use WithoutMiddleware;
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }

    public function testGetInstantUserWithToken()
    {
//        $this->get('api/Users/edit')
//            ->seeJson([
//                'success' => True,
//            ])->seeJsonStructure([
//                'success',
//                'data'=> [
//                    'data',
//                    'blocks'
//                ]
//            ]);
    }
//    public function testSaveInstantUserWithToken()
//    {
//        Auth::loginUsingId(1);
//        $this->json('post','api/Users/edit',[
//            'Objectname'=>'Users',
//            'email'=>'panit@gmail.com',
//            'firstname'=>'panit',
//            'lastname'=>'Jjr',
//            'confirm_password'=>'123456',
//            'password'=>'123456',
//            'role_id'=>'1',
//            'user_name' => 'Panit'
//        ])
//            ->seeJson([
//                'success' => True,
//            ]);
//        Auth::logout();
//    }

}
