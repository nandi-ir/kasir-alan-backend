<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // OrderItem::factory(48)->recycle([
        //     Order::factory(6)->create(),
        //     Product::factory(24)->create(),
        //     Payment::factory(6)->create(),
        // ])->create();

        Product::factory(20)->create();
    }
}
