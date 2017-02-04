<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/5/2017
 * Time: 1:29 AM
 */


use App\Object\Profiles\CCList;
use App\Object\Users\Users;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CCListProfileTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $User;
    protected $Role;
    protected $Profile;
    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(9);
        $role = new App\Object\Role\Role();
        $role->name = 'Admin';
        $role->role_description = 'Admin is Admin';
        $role->save();
        $this->Role = $role;
        $profile = new \App\Object\Profiles\Profiles();
        $profile->profilename = 'Test Admin';
        $profile->description = 'Profile Admin is admin profile';
        $profile->save();
        $this->Profile = $profile;
        $permission = new \App\Object\Profiles\Permission();
        $permission->objectid = 6;
        $permission->name = 'create';
        $permission->description = 'permission description';
        $permission->save();
        $permissionE = new \App\Object\Profiles\Permission();
        $permissionE->objectid = 6;
        $permissionE->name = 'edit';
        $permissionE->description = 'edit permission description';
        $permissionE->save();
        $permissiond = new \App\Object\Profiles\Permission();
        $permissiond->objectid = 6;
        $permissiond->name = 'delete';
        $permissiond->description = 'delete permission description';
        $permissiond->save();
        $permissionv= new \App\Object\Profiles\Permission();
        $permissionv->objectid = 6;
        $permissionv->name = 'view';
        $permissionv->description = 'view permission description';
        $permissionv->save();
        $testUser = new Users();
        $testUser->user_name = 'panit';
        $testUser->email = 'test@testtest.com';
        $testUser->role_id = $role->id;
        $testUser->supervisor_id = 9;
        $testUser->remember_token = 'Token';
        $testUser->save();
        DB::table('user_profile')->insert(['user_id'=>$testUser->id,'profile_id'=>$profile->id]);
        DB::table('profile_object_permission')->insert(['profile_id'=>$profile->id,'object_id'=>6,'permission_id'=>$permission->id]);
        DB::table('profile_object_permission')->insert(['profile_id'=>$profile->id,'object_id'=>6,'permission_id'=>$permissionE->id]);
        DB::table('profile_object_permission')->insert(['profile_id'=>$profile->id,'object_id'=>6,'permission_id'=>$permissionv->id]);
        DB::table('profile_object_permission')->insert(['profile_id'=>$profile->id,'object_id'=>6,'permission_id'=>$permissiond->id]);
        $this->User = $testUser;
    }
    public function testListProfile(){
        Auth::loginUsingId($this->User->id);
        $ccList = new CCList();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Profiles/list/');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();

        $request->setRouteResolver(function () use ($request) {
            return (new Route('Get', 'api/{objectName}/list/', []))->bind($request);
        });
        $this->assertTrue($ccList->checkPermission($request));
        $result = $ccList->process($request);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('header',$result);
        $this->assertArrayHasKey('listInfo',$result);
        $this->assertArrayHasKey('Profiles Name',$result['header']);
        $this->assertArrayHasKey('Description',$result['header']);
        foreach ($result['listInfo'] as $index => $aProfile){
            if($aProfile['id'] == $this->Profile->id){
                //var_dump($aProfile);
                $this->assertArrayHasKey('id',$aProfile);
                $this->assertArrayHasKey('Description',$aProfile);
                $this->assertEquals('Profile Admin is admin profile',$aProfile['Description']);
                $this->assertEquals('Test Admin',$aProfile['profilename']);
                $this->assertArrayHasKey('entity',$aProfile);
                $this->assertEquals(0,$aProfile['entity']['deleted']);
                break;
            }
        }

    }

}