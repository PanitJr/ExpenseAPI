<?php

use App\Object\Users\Users;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\ParameterBag;

class CCListUserTest extends TestCase
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
    public function testCCListUser()
    {
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Users/list/');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/list/', []))->bind($request);
        });
        $cclist = new \App\Object\Users\CCList();
        $this->assertTrue($cclist->checkPermission($request));
        $result = $cclist->process($request);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('header',$result);
        $this->assertArrayHasKey('listInfo',$result);
        $this->assertArrayHasKey('Username',$result['header']);
        foreach ($result['listInfo'] as $index => $auser){
            if($auser['id'] == $this->User->id){
                $this->assertArrayHasKey('id',$auser);
                $this->assertArrayHasKey('user_name',$auser);
                $this->assertEquals('panit',$auser['user_name']);
                $this->assertEquals('',$auser['firstname']);
                $this->assertEquals(4,$auser['role_id']);
                $this->assertArrayHasKey('entity',$auser);
                $this->assertArrayHasKey('id',$auser['entity']);
                $this->assertArrayHasKey('ownerid',$auser['entity']);
                $this->assertArrayHasKey('createid',$auser['entity']);
                $this->assertArrayHasKey('modifiedby',$auser['entity']);
                $this->assertArrayHasKey('created_at',$auser['entity']);
                $this->assertArrayHasKey('updated_at',$auser['entity']);
                $this->assertArrayHasKey('deleted',$auser['entity']);
                $this->assertArrayHasKey('label',$auser['entity']);
                $this->assertEquals(0,$auser['entity']['deleted']);
                break;
            }
        }
    }
    public function testCCListUserResponse(){
        $this->get('api/Users/list/')
            ->seeJson([
                'success' => True,

            ])->seeJsonStructure([
                'success',
                'data'=> [
                    'header',
                    'listInfo'=>[
                        'total',
                        'per_page',
                        'current_page',
                        'last_page',
                        'next_page_url',
                        'prev_page_url',
                        'from',
                        'to',
                        'data'=>[]
                    ]
                ]
            ]);
    }
}
