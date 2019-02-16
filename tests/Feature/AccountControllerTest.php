<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Account;

class AccountControllerTest extends TestCase
{
    /** @test */
    public function account_controller_creates_users()
    {
        $user  = factory(Account::class)->make();  
        $response = $this->post('/api/account', $user->toArray());
        $response->assertStatus(200);
    }

    /** @test */
    public function account_controller_doesnt_create_wrong_email() 
    {
        $user = factory(Account::class)->make();
        $data = $user->toArray();
        $data['email'] = 'foo';
        
        $response = $this->post('/api/account', $data);
        $response->assertStatus(422);
    }

    /** @test */
    public function account_controller_doesnt_create_wrong_password() 
    {
        $user = factory(Account::class)->make();
        $data = $user->toArray();
        $data['password'] = '1234';
        
        $response = $this->post('/api/account', $data);
        $response->assertStatus(422);
    }

    /** @test */
    public function account_controller_doesnt_create_wrong_company_name() 
    {
        $user = factory(Account::class)->make();
        $data = $user->toArray();
        $data['company_name'] = '';
        
        $response = $this->post('/api/account', $data);
        $response->assertStatus(422);
    }
}
