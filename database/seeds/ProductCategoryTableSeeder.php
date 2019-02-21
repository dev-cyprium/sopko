<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProductCategoryTableSeeder extends Seeder
{
    public function run()
    {
        $base_categories = [
            "clothes",
            "technology",
            "food",
        ];

        // Create base categories
        foreach ($base_categories as $category) {
            DB::table('product_categories')->insert([
                'title' => $category,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Make specific categories
        // for accounts 1 and 2
        factory(App\Models\ProductCategory::class, 20)->make()->each(function($category, $index) {
            if($index < 10) {
                $account_id = 1;
            } else {
                $account_id = 2;
            }

            $category->account_id = $account_id;
            $category->save();
        });
    }
}