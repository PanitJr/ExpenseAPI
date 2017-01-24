<?php

use App\Http\Controllers\User\loginController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoogleLoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     *
     *
     */
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }
    public function testGoogleLoginValidEmail()
    {

        $this->assertTrue(true);
        $this->json('post','api/logingoogle', ['u' => 'panit@crm-c.club'])
            ->seeJson([
                'success' => true,
            ])
            ->seeJsonStructure([
                'success',
                'data'=> [
                    'token'
                ]
            ]);
    }

}
