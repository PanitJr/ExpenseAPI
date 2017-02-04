<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 6:06 PM
 */



use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Expense\CCDetail;
use Illuminate\Support\Facades\Auth;


class CCDetailExpenseTest extends TestCase
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
