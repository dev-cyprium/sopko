<?php

use Illuminate\Database\Seeder;
use App\Models\Storage;

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
            $storage->type()->save($type1);
        });


        factory(Storage::class, 5)->make()->each(function($storage) use ($type2) {
            $storage->type()->save($type2);
        });
    }
}
