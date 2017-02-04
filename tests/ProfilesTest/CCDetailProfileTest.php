<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/5/2017
 * Time: 1:27 AM
 */



use App\Object\CC\CCDetail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;


class CCDetailProfileTest extends TestCase
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