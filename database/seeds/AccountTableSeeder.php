<?php

use Illuminate\Database\Seeder;
use App\Models\Account;
use Carbon\Carbon;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stefan = new Account();

        $stefan->company_name = "HTTPStef";
        $stefan->email = "stefke@email.com";
        $stefan->password_hash = '$2y$10$ndb6druVK85hjixMGW5L.uzsn.wceouxUy1wnnrYPcLoxv69QkLq6';
        $stefan->salt = "5c9ab9e08e3542.86102024";
        $now = Carbon::now();
        $stefan->created_at = $now;
        $stefan->updated_at = $now;
        $stefan->full_name  = "Stefan Kupresak";
        
        $stefan->save();
        DB::insert('insert into auth_keys (hash, account_id, created_at, updated_at) values (?, ?, ?, ?)'
            ,['0e6cc6a4b0773319c76fa23ab2805b34', $stefan->id, $now, $now]);

        factory(App\Models\Account::class, 4)->create()->each(function ($account) {
            $account->authKeys()->create();
        });
    }
}
 