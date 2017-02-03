<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/3/2017
 * Time: 5:00 PM
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Item\CCSave;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\ParameterBag;


class CCSaveItemTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $item;
    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(9);
//        $testItem = new \App\Object\Item\Item();
//        $testItem->category = 1;
//        $testItem->itemname = 'test-item-name';
//        $testItem->opportunity =1;
//        $testItem->cost =500;
//        $testItem->description ='test_description';
//        $testItem->attachment ='imageURL';
//        $testItem->status =1;
//        $testItem->date =\Carbon\Carbon::now();
//        $testItem->save();
//        $this->item = $testItem;
//        $testTravel = new \App\Object\Item\Travel();
//        $testTravel->item_id = $testItem->id;
//        $testTravel->travel_type=1;
//        $testTravel->travel_sub_type=1;
//        $testTravel->destination='siam';
//        $testTravel->origination='test station';
//        $testTravel->save();
    }
    public function testItemSave(){
        $ccSave = new CCSave();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Item/edit/null');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->request = new ParameterBag(['category' => 1,
            'itemname'=>'',
            'opportunity'=>1,
            'cost'=>500,
            'description'=>'',
            'status'=>1,
            'date'=>\Carbon\Carbon::now(),
            'travel'=>[
                'travel_type'=>1,
                'travel_sub_type'=>1,
                'destination'=>'siam',
                'origination'=>'test station'
            ]
        ]);
        $request->setRouteResolver(function () use ($request) {
            return (new Route('Post', 'api/{objectName}/edit/{record?}', []))->bind($request);
        });
        //var_dump($request->route('objectName'));
        $this->assertTrue($ccSave->checkPermission($request));
        $resualt = $ccSave->process($request);
        //var_dump($resualt);
        $this->assertNotEquals($resualt->id,null);
        $this->assertNotEquals($resualt->itemname,null);
        $this->assertEquals($resualt->cost,500);
        $this->assertEquals($resualt->opportunity,1);
    }

}
