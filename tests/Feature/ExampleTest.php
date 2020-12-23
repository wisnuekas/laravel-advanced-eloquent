<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRouteCustomerLogin()
    {
        $response = $this->get('/api/customer/login');

        $response->assertStatus(200);
    }

    public function testRouteMitraLogin()
    {
        $response = $this->get('/api/mitra/login');

        $response->assertStatus(200);
    }
}
