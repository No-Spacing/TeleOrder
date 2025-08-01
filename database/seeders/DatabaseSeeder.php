<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Code;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Role;
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

        Role::create(['role' => 'approver']);
        Role::create(['role' => 'encoder']);
        Role::create(['role' => 'sales']);
        Role::create(['role' => 'admin']);

        User::create([
            'name' => 'Approver',
            'email' => 'approver@inmed.com.ph',
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Encoder',
            'email' => 'encoder@inmed.com.ph',
            'password' => Hash::make('password'),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'Sales',
            'email' => 'sales@inmed.com.ph',
            'password' => Hash::make('password'),
            'role_id' => 3
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@inmed.com.ph',
            'password' => Hash::make('password'),
            'role_id' => 4
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
