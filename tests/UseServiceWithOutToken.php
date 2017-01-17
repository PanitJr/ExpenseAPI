<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UseServiceWithOutToken extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetInstantUserWithOutToken()
    {
        $this->get('api/Users/edit')
            ->seeJson([
                'success' => false,
                'error_code' => "TOKEN_EMPTY",
                'error_massage' => "Please send token"
            ])
            ->seeJsonStructure([
                'success',
                'error_code',
                'error_massage'
            ]);
    }
}
