<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/5/2017
 * Time: 1:29 AM
 */


use App\Object\Profiles\CCList;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;


class CCListProfileTest extends TestCase
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