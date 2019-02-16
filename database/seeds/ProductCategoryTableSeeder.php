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

        foreach ($base_categories as $category) {
            DB::table('product_categories')->insert([
                'title' => $category,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}