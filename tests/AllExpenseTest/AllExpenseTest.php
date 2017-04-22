<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 3/29/2017
 * Time: 9:23 PM
 */


use App\CC\Loader;
use App\Object\Expense\AllExpense;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\ParameterBag;


class AllExpenseTest extends TestCase{
    use WithoutMiddleware;
    use DatabaseTransactions;
    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(1000);
        $Expense = new \App\Object\Expense\Expense();
        $Expense->expensename = 'test_expense';
        $Expense->total_price = 1500;
        $Expense->user_id = 1000;
        $Expense->status = 2;
        $Expense->opportunity = 99;
        $Expense->approver = 9;
        $Expense->save();
        //Auth::logout();

        Auth::loginUsingId(1001);
        $Expense2 = new \App\Object\Expense\Expense();
        $Expense2->expensename = 'test_expense_3';
        $Expense2->total_price = 1500;
        $Expense->user_id = 1001;
        $Expense2->status = 1;
        $Expense2->opportunity = 99;
        $Expense2->approver = 9;
        $Expense2->save();

        $Expense3 = new \App\Object\Expense\Expense();
        $Expense3->expensename = 'test_expense_4';
        $Expense3->total_price = 1500;
        $Expense->user_id = 1001;
        $Expense3->status = 1;
        $Expense3->opportunity = 89;
        $Expense3->approver = 9;
        $Expense3->save();

        Auth::loginUsingId(1003);
        $Expense4 = new \App\Object\Expense\Expense();
        $Expense4->expensename = 'test_expense_5';
        $Expense4->total_price = 1500;
        $Expense->user_id = 1003;
        $Expense4->status = 1;
        $Expense4->opportunity = 89;
        $Expense4->approver = 9;
        $Expense4->save();

        $Expense5 = new \App\Object\Expense\Expense();
        $Expense5->expensename = 'test_expense_2';
        $Expense5->total_price = 1500;
        $Expense->user_id = 1003;
        $Expense5->status = 1;
        $Expense5->opportunity = 89;
        $Expense5->approver = 9;
        $Expense5->save();

        $inactiveOpp = new \App\Object\Opportunity\Opportunity();
        $inactiveOpp->name = 'inactiveOpp';
        $inactiveOpp->save();

    }
   /* public function testProcess(){
        Auth::loginUsingId(9);
        $AllExpense = new AllExpense();
        $result = $AllExpense->process($this->request);
        $this->assertTrue($AllExpense->checkPermission($this->request));
        $this->assertArrayHasKey('header',$result);
        $this->assertArrayHasKey('listInfo',$result);
        $this->assertArrayHasKey('expense_name',$result['header']);
        $this->assertEquals(5,sizeof($result['listInfo']));
        $this->assertEquals('test_expense_2',$result['listInfo'][sizeof($result['listInfo'])-1]['expensename']);
    }*/
    public function testGetFilters(){
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/AllExpense');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/AllExpense', []))->bind($request);
        });
        $request->request = new ParameterBag(
            [
                'userPickList'=>[
                    'user'=>0,
                    'Opp'=>0,
                    'status'=>0,
                    'month'=>0,
                    'year'=>0
                ]
            ]);
        $user = \App\Object\Users\Users::All();
        $AllExpense = new AllExpense();
        $res = $AllExpense->getFilters();
        $this->assertArrayHasKey('userlis',$res);
        $this->assertArrayHasKey('opplis',$res);
        foreach ($res['opplis'] as $opp ){
            $this->assertNotEquals('$inactiveOpp',$opp->name);
        }
        $this->assertArrayHasKey('statuslis',$res);
        $this->assertEquals(sizeof($user),sizeof($res['userlis']));
    }
    public function testCalTotal(){
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/AllExpense');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/AllExpense', []))->bind($request);
        });
        $request->request = new ParameterBag(
            [
                'userPickList'=>[
                    'user'=>0,
                    'Opp'=>99,
                    'status'=>0,
                    'month'=>0,
                    'year'=>0
                ]
            ]);
        $AllExpense = new AllExpense();
        $Expense = new \App\Object\Expense\Expense();
        $listModel = $AllExpense->getList($request,$Expense);

        $res = $AllExpense->calTotal($listModel);
        $this->assertEquals(1500*2,$res);

    }
    public function testEmployeeCheckpermission(){
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/AllExpense');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/AllExpense', []))->bind($request);
        });
        $request->request = new ParameterBag(
            [
                'userPickList'=>[
                    'user'=>0,
                    'Opp'=>89,
                    'status'=>1,
                    'month'=>0,
                    'year'=>0
                ]
            ]);
        $AllExpense = new AllExpense();
        Auth::loginUsingId(1003);
        $this->assertFalse($AllExpense->checkPermission($request));
    }
    public function testGetListByOpp(){
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/AllExpense');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/AllExpense', []))->bind($request);
        });
        $request->request = new ParameterBag(
            [
                'userPickList'=>[
                    'user'=>0,
                    'Opp'=>89,
                    'status'=>0,
                    'month'=>0,
                    'year'=>0
                ]
            ]);

        $AllExpense = new AllExpense();
        //$Expense = new \App\Object\Expense\Expense();
        $objectClass =  Loader::getObject('Expense');
        //$result = $AllExpense->process($this->request);
        $res = $AllExpense->getList($request,$objectClass);
        $this->assertEquals(3,sizeof($res));
        foreach ($res as $expense){
            $this->assertEquals(89,$expense->opportunity);
            $this->assertNotEmpty($expense->expensename);
            $this->assertNotEmpty($expense->status);
            $this->assertNotEmpty($expense->opportunity);
            $this->assertNotEmpty($expense->total_price);
        }
    }
    public function testGetListByUser(){
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/AllExpense');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/AllExpense', []))->bind($request);
        });
        $request->request = new ParameterBag(
            [
                'userPickList'=>[
                    'user'=>1000,
                    'Opp'=>0,
                    'status'=>0,
                    'month'=>0,
                    'year'=>0
                ]
            ]);

        $AllExpense = new AllExpense();
        //$Expense = new \App\Object\Expense\Expense();
        $objectClass =  Loader::getObject('Expense');
        //$result = $AllExpense->process($this->request);
        $res = $AllExpense->getList($request,$objectClass);
        $this->assertEquals(1,sizeof($res));
        foreach ($res as $expense){
            $this->assertNotEmpty($expense->expensename);
            $this->assertNotEmpty($expense->status);
            $this->assertNotEmpty($expense->opportunity);
            $this->assertNotEmpty($expense->total_price);
        }
    }
    public function testGetListByUserAndStatus(){
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/AllExpense');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/AllExpense', []))->bind($request);
        });
        $request->request = new ParameterBag(
            [
                'userPickList'=>[
                    'user'=>1000,
                    'Opp'=>0,
                    'status'=>1,
                    'month'=>0,
                    'year'=>0
                ]
            ]);

        $AllExpense = new AllExpense();
        //$Expense = new \App\Object\Expense\Expense();
        $objectClass =  Loader::getObject('Expense');
        //$result = $AllExpense->process($this->request);
        $res = $AllExpense->getList($request,$objectClass);
        $this->assertEquals(0,sizeof($res));
    }
    public function testGetListByOppAndDate(){
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/AllExpense');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/AllExpense', []))->bind($request);
        });
        $request->request = new ParameterBag(
            [
                'userPickList'=>[
                    'user'=>0,
                    'Opp'=>99,
                    'status'=>0,
                    'month'=>\Carbon\Carbon::now()->month,
                    'year'=>\Carbon\Carbon::now()->year
                ]
            ]);

        $AllExpense = new AllExpense();
        //$Expense = new \App\Object\Expense\Expense();
        $objectClass =  Loader::getObject('Expense');
        //$result = $AllExpense->process($this->request);
        $res = $AllExpense->getList($request,$objectClass);
        $this->assertEquals(2,sizeof($res));
        foreach ($res as $expense){
            $this->assertEquals(99,$expense->opportunity);
            $this->assertNotEmpty($expense->expensename);
            $this->assertNotEmpty($expense->status);
            $this->assertNotEmpty($expense->opportunity);
            $this->assertNotEmpty($expense->total_price);
        }
    }

}
