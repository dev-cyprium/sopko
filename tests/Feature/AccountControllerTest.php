<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Account;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountControllerTest extends TestCase
{
    use DatabaseTransactions;

    private function accountParams($opts = [])
    {
        return array_merge([
          "company_name" => "Foo Bar",
          "email"        => "foo@bar.com",
          "password"     => "secret" 
        ], $opts);
    }

    /** @test */
    public function account_controller_creates_users()
    {
        $response = $this->post('/api/account', $this->accountParams());
        $response->assertStatus(200);
    }

    /** @test */
    public function account_controller_doesnt_create_wrong_email() 
    {
        $response = $this->post('/api/account', $this->accountParams(['email' => 'foo']));
        $response->assertStatus(422);
    }

    /** @test */
    public function account_controller_doesnt_create_wrong_password() 
    {   
        $response = $this->post('/api/account', $this->accountParams(['password' => '1234']));
        $response->assertStatus(422);
    }

    /** @test */
    public function account_controller_doesnt_create_wrong_company_name() 
    {
        $response = $this->post('/api/account', $this->accountParams(['company_name' => '']));
        $response->assertStatus(422);
    }
}
