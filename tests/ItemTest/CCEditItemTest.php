<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/3/2017
 * Time: 5:09 PM
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Item\CCEdit;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\ParameterBag;


class CCEditItemTest extends TestCase
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
    public function testItemEditGetInstant(){
        $ccEdit = new CCEdit();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Item/edit/');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/edit/{record?}', []))->bind($request);
        });
        $this->assertTrue($ccEdit->checkPermission($request));
        $result = $ccEdit->process($request);
        $block = $result['blocks'][0];
        //var_dump($block);
        $this->assertArrayHasKey('objectname',$result);
        $this->assertArrayHasKey('record',$result);
        $this->assertArrayHasKey('label',$result);
        $this->assertArrayHasKey('blocks',$result);
        $this->assertArrayHasKey('data',$result);
        $this->assertNotEmpty($block);
        $this->assertArrayHasKey('fields',$block);
        $this->assertArrayHasKey('traveltype',$block['fields']);
        $this->assertArrayHasKey('travelsubtype',$block['fields']);
        $this->assertArrayHasKey('servicetype',$block['fields']);
    }
    public function testItemEditGetRecord(){
        $ccEdit = new CCEdit();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Item/edit/'.$this->item->id);
        app()->instance('request', $requestMock->getMock());
        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/edit/{record?}', []))->bind($request);
        });
        $this->assertTrue($ccEdit->checkPermission($request));
        $result = $ccEdit->process($request);
        $block = $result['blocks'][0];
        $itemResult = $result['data'];
        //var_dump($block);
        $this->assertArrayHasKey('objectname',$result);
        $this->assertArrayHasKey('record',$result);
        $this->assertArrayHasKey('label',$result);
        $this->assertArrayHasKey('blocks',$result);
        $this->assertArrayHasKey('data',$result);
        $this->assertNotEmpty($block);
        $this->assertArrayHasKey('fields',$block);
        $this->assertArrayHasKey('traveltype',$block['fields']);
        $this->assertArrayHasKey('travelsubtype',$block['fields']);
        $this->assertArrayHasKey('servicetype',$block['fields']);
        $this->assertEquals($itemResult['id'],$this->item->id);
        $this->assertEquals($itemResult['itemname'],'test-item-name');
        $this->assertEquals($itemResult['attachment'],'imageURL');
    }
}
