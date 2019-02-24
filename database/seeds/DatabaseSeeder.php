<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AccountTableSeeder::class);
        $this->call(ProductCategoryTableSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(StorageTypeSeeder::class);
        $this->call(StorageSeeder::class);
    }
}
