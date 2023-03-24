<?php

namespace Tests\Feature\Models;

use Tests\TestCase;

class ClaimTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
