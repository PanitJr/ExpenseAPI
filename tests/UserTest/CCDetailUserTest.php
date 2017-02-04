<?php

use App\Object\Users\Users;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class UpdateUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $User;

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
        $testUser->entity;
        $this->User = $testUser;
//        $Lodader= $this->createMock(\App\CC\Loader::class);
//
//        // Configure the stub.
//        $Lodader->method('getObject')
    }
    public function testCCDetailUser()
    {
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Users/detail/'.$this->User['id']);

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/detail/{record}', []))->bind($request);
        });
        $ccDetail = new \App\Object\Users\CCDetail();
        $this->assertTrue($ccDetail->checkPermission($request));
        $result = $ccDetail->process($request);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('objectname',$result);
        $this->assertArrayHasKey('record',$result);
        $this->assertArrayHasKey('label',$result);
        $this->assertArrayHasKey('blocks',$result);
        $this->assertArrayHasKey('id',$result['blocks'][0]);
        $this->assertArrayHasKey('objectid',$result['blocks'][0]);
        $this->assertArrayHasKey('blocklabel',$result['blocks'][0]);
        $this->assertArrayHasKey('sequence',$result['blocks'][0]);
        $this->assertArrayHasKey('fields',$result['blocks'][0]);
        $this->assertArrayHasKey('data',$result);
        $this->assertEquals($this->User->id,$result['data']['id']);
        $this->assertEquals('test@testtest.com',$result['data']['email']);
        $this->assertEquals('panit',$result['data']['user_name']);

    }
}
