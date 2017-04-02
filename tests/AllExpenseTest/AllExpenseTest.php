<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 3/29/2017
 * Time: 9:23 PM
 */


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
    protected $testExpense;
    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(9);
        $Expense = new \App\Object\Expense\Expense();
        $Expense->expensename = 'test_expense';
        $Expense->total_price = 50;
        $Expense->status = 1;
        $Expense->opportunity = 24;
        $Expense->approver = 9;
        $Expense->save();
        $item = new \App\Object\Item\Item();
        $item->itemname = 'test_item_01';
        $item->expense_id = $Expense->id;
        $item->save();
        $this->testExpense = $Expense;

        $Expense = new \App\Object\Expense\Expense();
        $Expense->expensename = 'test_expense_2';
        $Expense->total_price = 50;
        $Expense->status = 1;
        $Expense->opportunity = 24;
        $Expense->approver = 9;
        $Expense->save();
        $item = new \App\Object\Item\Item();
        $item->itemname = 'test_item_02';
        $item->expense_id = $Expense->id;
        $item->save();
        $this->testExpense = $Expense;
    }
    public function test(){
        $AllExpense = new AllExpense();
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
                    'month'=>\Carbon\Carbon::now()->month,
                    'year'=>\Carbon\Carbon::now()->year
                ]
            ]);

        $this->assertTrue($AllExpense->checkPermission($request));
        $result = $AllExpense->process($request);
        $this->assertArrayHasKey('header',$result);
        $this->assertArrayHasKey('listInfo',$result);
        $this->assertArrayHasKey('expense_name',$result['header']);
        $this->assertEquals(2,sizeof($result['listInfo']));
        $this->assertEquals('test_expense_2',$result['listInfo'][sizeof($result['listInfo'])-1]['expensename']);
    }
}
