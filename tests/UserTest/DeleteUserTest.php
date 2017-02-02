<?php

use App\Object\Users\Users;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class DeleteUserTest extends TestCase
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
        \Illuminate\Support\Facades\Auth::loginUsingId(9);
        $testUser = new Users();
        $testUser->user_name = 'panit';
        $testUser->email = 'test@testtest.com';
        $testUser->role_id = 4;
        $testUser->supervisor_id = 9;
        $testUser->remember_token = 'Token';
        $testUser->save();
        $testUser->entity();
        $this->User = $testUser;
//        $Lodader= $this->createMock(\App\CC\Loader::class);
//
//        // Configure the stub.
//        $Lodader->method('getObject')
//            ->willReturn($this->User);
    }

    public function testCCDeleteUser()
    {
        $ccDelete = new \App\Object\Users\CCDelete();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->andReturn('Users/edit/'.$this->User['id']);

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('Post', '{objectName}/delete/{record}', []))->bind($request);
        });
        $this->assertTrue($ccDelete->checkPermission($request));
        //$ccDelete->process($request);
    }
}
