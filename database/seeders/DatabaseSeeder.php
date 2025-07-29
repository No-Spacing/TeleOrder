<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Code;
use App\Models\Customer;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Encoder',
            'email' => 'encoder@email.com',
            'password' => Hash::make('password'),
        ]);

        // Code::create(['code' => 123]);

        // Customer::create([
        //     'code_id' => 1,
        //     'customer' => 'Test',
        // ]);

        // Product::create([
        //     'code' => 'Test123',
        //     'description' => 'Test Description',
        //     'uom' => 'Each',
        // ]);
    }
}
