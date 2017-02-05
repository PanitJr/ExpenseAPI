<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/3/2017
 * Time: 5:05 PM
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Item\CCList;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;


class CCListItemTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
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
        $testItem->status =1;
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
    public function testItemList(){
        $ccItem = new CCList();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Item/list/');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/list/', []))->bind($request);
        });
        $this->assertTrue($ccItem->checkPermission($request));
        $result = $ccItem->process($request);
//        var_dump($result['listInfo']);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('header',$result);
        $this->assertArrayHasKey('listInfo',$result);
        $this->assertArrayHasKey('Item',$result['header']);
//      $this->assertArrayHasKey('total',$result['listInfo']);
//      $this->assertArrayHasKey('per_page',$result['listInfo']);
//      $this->assertArrayHasKey('current_page',$result['listInfo']);
//      $this->assertArrayHasKey('last_page',$result['listInfo']);
//      $this->assertArrayHasKey('next_page_url',$result['listInfo']);
//      $this->assertArrayHasKey('prev_page_url',$result['listInfo']);
//      $this->assertArrayHasKey('from',$result['listInfo']);
//      $this->assertArrayHasKey('to',$result['listInfo']);
//      $this->assertArrayHasKey('data',$result['listInfo']);
        foreach ($result['listInfo'] as $index => $item){
        $this->assertArrayHasKey('id',$item);
        $this->assertArrayHasKey('itemname',$item);
        $this->assertArrayHasKey('entity',$item);
        $this->assertArrayHasKey('id',$item['entity']);
        $this->assertArrayHasKey('ownerid',$item['entity']);
        $this->assertArrayHasKey('createid',$item['entity']);
        $this->assertArrayHasKey('modifiedby',$item['entity']);
        $this->assertArrayHasKey('created_at',$item['entity']);
        $this->assertArrayHasKey('updated_at',$item['entity']);
        $this->assertArrayHasKey('deleted',$item['entity']);
        $this->assertArrayHasKey('label',$item['entity']);
        $this->assertEquals(0,$item['entity']['deleted']);
        break;
        }

    }
}
