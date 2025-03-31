<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SactumTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_company_can_login(): void
    {
        $company = Company::factory()->create([
            'email' => 'test@test.es',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/api/v1/login', [
            'email' => $company->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }
}
