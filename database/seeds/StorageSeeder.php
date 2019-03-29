<?php

use Illuminate\Database\Seeder;
use App\Models\Storage;
use App\Models\StorageType;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type1 = StorageType::find(1);
        $type2 = StorageType::find(2);

        factory(Storage::class, 5)->make()->each(function($storage) use ($type1) {
            $storage->type()->associate($type1);
            $storage->account_id = 1;
            $storage->save();
        });
        
        
        factory(Storage::class, 5)->make()->each(function($storage) use ($type2) {
            $storage->type()->associate($type2);
            $storage->account_id = 1;
            $storage->save();
        });
    }
}
