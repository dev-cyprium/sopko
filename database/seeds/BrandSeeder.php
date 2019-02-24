<?php

use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Brand::class, 10)->make()->each(function ($brand, $index) {
            if($index < 5) {
                $brand->account_id = 1;
            } else {
                $brand->account_id = 2;
            }

            $brand->save();
        });
    }
}
