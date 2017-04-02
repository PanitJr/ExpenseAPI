<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 3/29/2017
 * Time: 9:24 PM
 */



use app\Http\Controllers\AllExpensePDF;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;


class AllExpensePDFTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $item;
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
        $this->assertTrue(true);
    }
}
