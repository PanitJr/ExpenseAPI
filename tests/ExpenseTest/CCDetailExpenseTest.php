<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 6:06 PM
 */



use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Expense\CCDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;


class CCDetailExpenseTest extends TestCase
{
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
    }
    public function test(){
        $ccDetail = new CCDetail();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/detail/'.$this->testExpense->id);

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
        $this->assertEquals($this->testExpense->id,$resualt['data']['id']);
        $this->assertEquals('test_expense',$resualt['data']['expensename']);
    }
}
