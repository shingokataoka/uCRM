<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Item;
use App\Models\Purchase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            ItemSeeder::class,
            RankSeeder::class,
        ]);

        \App\Models\Customer::factory(1000)->create();

        $items = Item::all();
        Purchase::factory(30000)->create()
            ->each(function(Purchase $purchase) use($items) {
                $itemIds = $items->random(rand(1,3))
                    ->pluck('id')->toArray();
                foreach($itemIds as $itemId) {
                    $purchase->items()->attach(
                        $itemId,
                        ['quantity' => rand(1,5)]
                    );
                }
            });
    }
}
