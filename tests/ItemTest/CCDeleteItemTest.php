<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/3/2017
 * Time: 5:08 PM
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Item\CCDelete;


class CCDeleteItemTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    public function setUp(){
        parent::setUp();
    }
    public function testItemDelete(){
        $this->assertTrue(true);
    }
}
