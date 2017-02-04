<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 6:05 PM
 */


use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Expense\CCList;
use Illuminate\Support\Facades\Auth;


class CCListExpenseTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(9);
    }
    public function test(){
        $this->assertTrue(true);
    }
}

