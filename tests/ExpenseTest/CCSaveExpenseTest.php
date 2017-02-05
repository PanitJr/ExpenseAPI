<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 6:03 PM
 */


use App\Object\Item\Item;
use App\Object\Opportunity\Opportunity;
use App\Object\Users\Users;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Expen\CCSave;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CCSaveExpenseTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $user;
    protected $oppTest1;
    protected $oppTest2;
    protected $item1;
    protected $item2;
    protected $item3;
    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(9);
        $role = new App\Object\Role\Role();
        $role->name = 'Admin';
        $role->role_description = 'Admin is Admin';
        $role->save();
        $profile = new \App\Object\Profiles\Profiles();
        $profile->profilename = 'Admin';
        $profile->description = 'Profile Admin is admin profile';
        $profile->save();
        $permission = new \App\Object\Profiles\Permission();
        $permission->objectid = 9;
        $permission->name = 'create';
        $permission->description = 'permission create expense description';
        $permission->save();
        $testUser = new Users();
        $testUser->user_name = 'panit';
        $testUser->email = 'test@testtest.com';
        $testUser->role_id = $role->id;
        $testUser->supervisor_id = 9;
        $testUser->remember_token = 'Token';
        $testUser->save();
        DB::table('user_profile')->insert(['user_id'=>$testUser->id,'profile_id'=>$profile->id]);
        DB::table('profile_object_permission')->insert(['profile_id'=>$profile->id,'object_id'=>5,'permission_id'=>$permission->id]);
        $this->user = $testUser;
        Auth::loginUsingId($this->user->id);
        $oppTest1 = new Opportunity();
        $oppTest1->name = 'opptest01';
        $oppTest1->active = 1;
        $oppTest1->save();
        $this->oppTest1=$oppTest1;
        $oppTest2 = new Opportunity();
        $oppTest2->name = 'opptest02';
        $oppTest2->active = 1;
        $oppTest2->save();
        $this->oppTest2=$oppTest2;
        $item1 = new Item();
        $item1->category = 1;
        $item1->itemname = 'test1-item-name';
        $item1->opportunity =$this->oppTest2->id;
        $item1->cost =600;
        $item1->description ='test_description';
        $item1->attachment ='imageURL';
        $item1->status =1;
        $item1->date =\Carbon\Carbon::now();
        $item1->save();
        $this->item1 = $item1;
        $item2 = new Item();
        $item2->category = 1;
        $item2->itemname = 'test2-item-name';
        $item2->opportunity =$this->oppTest1->id;
        $item2->cost =300;
        $item2->description ='test_description';
        $item2->attachment ='imageURL';
        $item2->status =1;
        $item2->date =\Carbon\Carbon::now();
        $item2->save();
        $this->item2 = $item2;
        $item3 = new Item();
        $item3->category = 1;
        $item3->itemname = 'test3-item-name';
        $item3->opportunity =$this->oppTest1->id;
        $item3->cost =200;
        $item3->description ='test_description';
        $item3->attachment ='imageURL';
        $item3->status =3;
        $item3->date =\Carbon\Carbon::now();
        $item3->save();
        $this->item3 = $item3;
    }
    public function testExpenseCreation (){
        //$this->assertEquals($this->item3->entity->ownerid,$this->user->id);
        $ccSave = new \App\Object\Expense\CCSave();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/edit/null');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();

        $request->setRouteResolver(function () use ($request) {
            return (new Route('Post', 'api/{objectName}/edit/{record?}', []))->bind($request);
        });
        $this->assertTrue($ccSave->checkPermission($request));
        $result = $ccSave->process($request);
        //var_dump($result);
        $this->assertTrue(!empty($result));
        foreach ($result as $expense){
            $this->assertArrayHasKey('opportunity',$expense);
            $this->assertArrayHasKey('status',$expense);
            $this->assertArrayHasKey('user_id',$expense);
            $this->assertArrayHasKey('expensename',$expense);
            $this->assertArrayHasKey('total_price',$expense);
            $this->assertEquals('panit-Expense-'.$expense->id,$expense->expensename);
            if($expense->opportunity == $this->oppTest2->id){
                $this->assertEquals(600,$expense->total_price);
            }
            if($expense->opportunity == $this->oppTest1->id){
                $this->assertEquals(500,$expense->total_price);
            }
        }

    }
}
