<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 6:05 PM
 */


use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use App\Object\Item\Item;
use App\Object\Opportunity\Opportunity;
use App\Object\Users\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;


class CCListExpenseTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $ExpenseList;
    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(1000);
        $Expense_1 = new \App\Object\Expense\Expense();
        $Expense_1->expensename = 'test_expense_1';
        $Expense_1->total_price = 1500;
        $Expense_1->status = 1;
        $Expense_1->opportunity = 99;
        $Expense_1->approver = 9;
        $Expense_1->save();

        Auth::loginUsingId(1001);
        $Expense_2 = new \App\Object\Expense\Expense();
        $Expense_2->expensename = 'test_expense_2';
        $Expense_2->total_price = 1000;
        $Expense_2->status = 1;
        $Expense_2->opportunity = 99;
        $Expense_2->approver = 9;
        $Expense_2->save();

        Auth::loginUsingId(1003);
        $Expense_3 = new \App\Object\Expense\Expense();
        $Expense_3->expensename = 'test_expense_3';
        $Expense_3->total_price = 500;
        $Expense_3->status = 1;
        $Expense_3->opportunity = 99;
        $Expense_3->approver = 9;
        $Expense_3->save();

        $this->ExpenseList = [$Expense_1,$Expense_2,$Expense_3];
    }
    public function testAdmCheckPermission(){
        Auth::loginUsingId(9);  //Admin
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/list/');

        app()->instance('request', $requestMock->getMock());

        $ExpenseList =  new \App\Object\Expense\CCList();
        $this->assertTrue($ExpenseList->checkPermission($requestMock));
    }
    public function testSupCheckPermission(){
        Auth::loginUsingId(35); //SuperVisor
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/list/');

        app()->instance('request', $requestMock->getMock());

        $ExpenseList =  new \App\Object\Expense\CCList();
        $this->assertTrue($ExpenseList->checkPermission($requestMock));
    }
    public function testEmpCheckPermission(){
        Auth::loginUsingId(661);//Employer
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/list/');

        app()->instance('request', $requestMock->getMock());

        $ExpenseList =  new \App\Object\Expense\CCList();
        $this->assertTrue($ExpenseList->checkPermission($requestMock));
    }

    /**
     *
     */
    public function testAdmRecordControll(){
        Auth::loginUsingId(1000);//Employer
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/list/');

        app()->instance('request', $requestMock->getMock());
        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/list/', []))->bind($request);
        });
        /*$MockExpenseList = $this->getMockBuilder(\App\Object\Expense\CCList::class);
        $MockExpenseList->method('getList')->willReturn($this->ExpenseList);*/
        $ExpenseList =  new \App\Object\Expense\CCList();
        $result = $ExpenseList->recordControl($this->ExpenseList);
        //var_dump($result);
        $this->assertTrue(!empty($result));
        $this->assertEquals(3,sizeof($result));
        foreach ($result as $expense){
            $this->assertEquals('cc_expenses',$expense->table);
        }
    }
    public function testSupRecordControll(){
        Auth::loginUsingId(1001);//Employer
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/list/');

        app()->instance('request', $requestMock->getMock());
        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/list/', []))->bind($request);
        });
        /*$MockExpenseList = $this->getMockBuilder(\App\Object\Expense\CCList::class);
        $MockExpenseList->method('getList')->willReturn($this->ExpenseList);*/
        $ExpenseList =  new \App\Object\Expense\CCList();
        $result = $ExpenseList->recordControl($this->ExpenseList);
        //var_dump($result);
        $this->assertTrue(!empty($result));
        $this->assertEquals(2,sizeof($result));
        foreach ($result as $expense){
            $this->assertEquals('cc_expenses',$expense->table);
            $this->assertNotEquals('test_expense_1',$expense->expensename);
        }
    }
    public function testEmpRecordControll(){
        Auth::loginUsingId(1003);//Employer
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/list/');

        app()->instance('request', $requestMock->getMock());
        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'api/{objectName}/list/', []))->bind($request);
        });
        /*$MockExpenseList = $this->getMockBuilder(\App\Object\Expense\CCList::class);
        $MockExpenseList->method('getList')->willReturn($this->ExpenseList);*/
        $ExpenseList =  new \App\Object\Expense\CCList();
        $result = $ExpenseList->recordControl($this->ExpenseList);
        //var_dump($result);
        $this->assertTrue(!empty($result));
        $this->assertEquals(1,sizeof($result));
        foreach ($result as $expense){
            $this->assertEquals('cc_expenses',$expense->table);
            $this->assertNotEquals('test_expense_1',$expense->expensename);
            $this->assertNotEquals('test_expense_2',$expense->expensename);
        }
    }

}

