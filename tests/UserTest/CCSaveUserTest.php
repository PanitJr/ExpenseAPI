<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 2:13 PM
 */

use App\Object\Users\CCSave;
use App\Object\Users\Users;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\ParameterBag;


class CCSaveUserTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $User;
    protected $Role;
    protected $Profile;
    public function setUp()
    {
        parent::setUp();
        \Illuminate\Support\Facades\Auth::loginUsingId(9);
        $role = new App\Object\Role\Role();
        $role->name = 'Admin';
        $role->role_description = 'Admin is Admin';
        $role->save();
        $this->Role = $role;
        $profile = new \App\Object\Profiles\Profiles();
        $profile->profilename = 'Admin';
        $profile->description = 'Profile Admin is admin profile';
        $profile->save();
        $this->Profile = $profile;
        $permission = new \App\Object\Profiles\Permission();
        $permission->objectid = 5;
        $permission->name = 'create';
        $permission->description = 'permission description';
        $permission->save();
        $permissionE = new \App\Object\Profiles\Permission();
        $permissionE->objectid = 5;
        $permissionE->name = 'edit';
        $permissionE->description = 'edit permission description';
        $permissionE->save();
        $testUser = new Users();
        $testUser->user_name = 'panit';
        $testUser->email = 'test@testtest.com';
        $testUser->role_id = $role->id;
        $testUser->supervisor_id = 9;
        $testUser->remember_token = 'Token';
        $testUser->save();
        DB::table('user_profile')->insert(['user_id'=>$testUser->id,'profile_id'=>$profile->id]);
        DB::table('profile_object_permission')->insert(['profile_id'=>$profile->id,'object_id'=>5,'permission_id'=>$permission->id]);
        DB::table('profile_object_permission')->insert(['profile_id'=>$profile->id,'object_id'=>5,'permission_id'=>$permissionE->id]);
        $this->User = $testUser;
    }
    public function testCCSaveNewUser(){
        $ccSave = new CCSave();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Users/edit/null');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();

        $request->setRouteResolver(function () use ($request) {
            return (new Route('Post', 'api/{objectName}/edit/{record?}', []))->bind($request);
        });
        $request->request = new ParameterBag([
            'user_name' => 'new_user_test',
            'email'=>'newUser@User.com',
            'role_id'=>$this->Role->id,
            'profiles_id'=>$this->Profile->id,
            'supervisor_id'=>$this->User->id,
            'remember_token'=>'NewUserToken'
        ]);
        $result = $ccSave->process($request);
        $this->assertNotEquals(null,$request);
        $this->assertEquals(true,$ccSave->checkPermission($request));
        $this->assertEquals('new_user_test',$result->user_name);
        $this->assertEquals('newUser@User.com',$result->email);
        $this->assertEquals($this->Role->id,$result->role_id);
        $this->assertEquals($this->User->id,$result->supervisor_id);
    }
    public function testCCSaveUser(){
        \Illuminate\Support\Facades\Auth::loginUsingId($this->User->id);
        $ccSave = new CCSave();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Users/edit/'.$this->User->id);

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('Post', 'api/{objectName}/edit/{record?}', []))->bind($request);
        });
        $request->request = new ParameterBag([
            'user_name' => 'new_panit_test',
            'email'=>'newTest@test123.com',
            'role_id'=>4,
            'supervisor_id'=>9,
            'remember_token'=>'Token'
        ]);
        $result = $ccSave->process($request);
        $this->assertNotEquals(null,$request);
        $this->assertEquals(true,$ccSave->checkPermission($request));
        $this->assertEquals($this->User->id,$result->id);
        $this->assertEquals('new_panit_test',$result->user_name);
        $this->assertEquals('newTest@test123.com',$result->email);
        $this->assertEquals(4,$result->role_id);
        $this->assertEquals(9,$result->supervisor_id);
    }
}
