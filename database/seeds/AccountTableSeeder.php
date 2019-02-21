<?php

use Illuminate\Database\Seeder;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Account::class, 4)->create()->each(function ($account) {
            $account->authKeys()->create();
        });
    }
}
 