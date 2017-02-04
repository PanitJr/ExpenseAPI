<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/3/2017
 * Time: 5:08 PM
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Item\CCDelete;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CCDeleteItemTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $item;
    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(9);
        $testItem = new \App\Object\Item\Item();
        $testItem->category = 1;
        $testItem->itemname = 'test-item-name';
        $testItem->opportunity =1;
        $testItem->cost =500;
        $testItem->description ='test_description';
        $testItem->attachment ='imageURL';
        $testItem->status ='1';
        $testItem->date =\Carbon\Carbon::now();
        $testItem->save();
        $this->item = $testItem;
        $testTravel = new \App\Object\Item\Travel();
        $testTravel->item_id = $testItem->id;
        $testTravel->travel_type=1;
        $testTravel->travel_sub_type=1;
        $testTravel->destination='siam';
        $testTravel->origination='test station';
        $testTravel->save();
    }
    public function testItemDelete(){
        $ccDelete = new CCDelete();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Item/delete/'.$this->item->id);

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('Post', 'api/{objectName}/delete/{record?}', []))->bind($request);
        });
        $this->assertTrue($ccDelete->checkPermission($request));
        $result = $ccDelete->process($request);
        $this->assertEquals(true,$result);
        $entity = DB::table('entitys')->where('id',$this->item->id)->first();
        $this->assertEquals(1,$entity->deleted);

    }
}
