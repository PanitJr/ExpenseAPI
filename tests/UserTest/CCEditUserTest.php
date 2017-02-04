<?php

use App\Object\Users\Users;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\ParameterBag;

class CCEditUserTest extends TestCase
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
        $this->User = $testUser;
    }

    public function testGetInstanceEditUser()
    {
        $this->get('api/Users/edit/')
            ->seeJson([
                'success' => True,

            ])->seeJsonStructure([
                'success',
                'data'=> [
                    'data',
                    'blocks'
                ]
            ]);
    }
    public function testGetEditUser(){
        $this->get('api/Users/edit/'.$this->User['id'])
            ->seeJson([
                'success' => True
            ])->seeJsonStructure([
                'success',
                'data'=> [
                    'data',
                    'blocks'
                ]
            ]);
    }
    public function testCCEditUserGetInstance(){
        $ccEdit = new \App\Object\Users\CCEdit();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Users/edit/null');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();

        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/edit/{record?}', []))->bind($request);
        });
        $this->assertEquals(true,$ccEdit->checkPermission($request));
        //$this->assertNotEquals($ccEdit->convertLayout($this->User),null);
        $result = $ccEdit->process($request);
        $block = $result['blocks'][0];
        $UserResult = $result['data'];
        //var_dump($block);
        $this->assertArrayHasKey('objectname',$result);
        $this->assertArrayHasKey('record',$result);
        $this->assertArrayHasKey('label',$result);
        $this->assertArrayHasKey('blocks',$result);
        $this->assertArrayHasKey('data',$result);
        $this->assertNotEmpty($block);
        $this->assertArrayHasKey('fields',$block);
        foreach ($block['fields'] as $field) {
            if ($field['fieldlabel'] == 'Role'){
                $this->assertArrayHasKey('Role', $field);
                $this->assertArrayHasKey('Profile', $field);
            }
            if ($field['fieldlabel'] == 'supervisor') {
                $this->assertArrayHasKey('supervisor', $field);
            }
            if ($field['fieldlabel'] == 'status') {
                $this->assertArrayHasKey('status', $field);
            }
        }
    }
    public function testCCEditUser(){
        $ccEdit = new \App\Object\Users\CCEdit();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Users/edit/'.$this->User['id']);

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();

        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/edit/{record?}', []))->bind($request);
        });
        $this->assertEquals(true,$ccEdit->checkPermission($request));
        //$this->assertNotEquals($ccEdit->convertLayout($this->User),null);
        $result = $ccEdit->process($request);
        $block = $result['blocks'][0];
        $UserResult = $result['data'];
        //var_dump($block);
        $this->assertArrayHasKey('objectname',$result);
        $this->assertArrayHasKey('record',$result);
        $this->assertArrayHasKey('label',$result);
        $this->assertArrayHasKey('blocks',$result);
        $this->assertArrayHasKey('data',$result);
        $this->assertNotEmpty($block);
        $this->assertArrayHasKey('fields',$block);
        foreach ($block['fields'] as $field) {
            if ($field['fieldlabel'] == 'Role'){
                $this->assertArrayHasKey('Role', $field);
                $this->assertArrayHasKey('Profile', $field);
            }
            if ($field['fieldlabel'] == 'supervisor') {
                $this->assertArrayHasKey('supervisor', $field);
            }
            if ($field['fieldlabel'] == 'status') {
                $this->assertArrayHasKey('status', $field);
            }
        }
        $this->assertEquals($UserResult['id'],$this->User->id);
        $this->assertEquals($UserResult['user_name'],'panit');
        $this->assertEquals($UserResult['email'],'test@testtest.com');

    }

}
