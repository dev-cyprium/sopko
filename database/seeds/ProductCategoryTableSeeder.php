<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\ProductCategory;

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

        // Add parents for some categories
        $category4 = ProductCategory::find(4);
        $category4->parent_id = 1;

        $category5 = ProductCategory::find(5);
        $category5->parent_id = 1;

        $category6 = ProductCategory::find(6);
        $category6->parent_id = 5;

        $category7 = ProductCategory::find(7);
        $category7->parent_id = 5;
    
        $category4->save();
        $category5->save();
        $category6->save();
        $category7->save();
    }
}