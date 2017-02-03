<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/3/2017
 * Time: 5:01 PM
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Item\CCDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;


class CCDetailItemTest extends TestCase
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
    public function testItemDetail(){
        $ccDetail = new CCDetail();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Item/detail/'.$this->item->id);

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/detail/{record?}', []))->bind($request);
        });
        $this->assertTrue($ccDetail->checkPermission($request));
        $resualt = $ccDetail->process($request);
        $this->assertNotEmpty($resualt,null);
        $this->assertArrayHasKey('objectname',$resualt);
        $this->assertArrayHasKey('record',$resualt);
        $this->assertArrayHasKey('label',$resualt);
        $this->assertArrayHasKey('blocks',$resualt);
        $this->assertArrayHasKey('id',$resualt['blocks'][0]);
        $this->assertArrayHasKey('objectid',$resualt['blocks'][0]);
        $this->assertArrayHasKey('blocklabel',$resualt['blocks'][0]);
        $this->assertArrayHasKey('sequence',$resualt['blocks'][0]);
        $this->assertArrayHasKey('fields',$resualt['blocks'][0]);
        $this->assertArrayHasKey('data',$resualt);
        $this->assertEquals($this->item->id,$resualt['data']['id']);
        $this->assertEquals('test-item-name',$resualt['data']['itemname']);
    }

}
