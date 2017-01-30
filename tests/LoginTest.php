<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;


class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     *
     *
     */
    use DatabaseTransactions;
    //use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

    }
    public function  testLogin(){
        \Illuminate\Support\Facades\Auth::loginUsingId(9);
        $User = new \App\Object\Users\Users();
        $User->user_name = 'panit';
        $User->email = 'test@testtest.com';
        $User->role_id = 4;
        $User->supervisor_id = 9;
        $User->remember_token = 'Token';
        $User->save();
        $Request = new Request(['u' => 'test@testtest.com','Fname'=>'','Lname'=>'']);

        $Login = new \App\Object\Users\Login($User);

        $token = $Login->process($Request)['token'];
        $this->assertEquals('Token',$token);
    }
    public function testLoginValidEmail()
    {

        $this->assertTrue(true);
        $this->json('post','api/logingoogle', ['u' => 'panit@crm-c.club'])
            ->seeJson([
                'success' => true,
            ])
            ->seeJsonStructure([
                'success',
                'data'=> [
                    'token'
                ]
            ]);
    }

}
