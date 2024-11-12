<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        
        User::create([
            'name' => 'Rudy',
            'email' => 'rudy@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        
        $category = Category::create([
            'name' => 'Sedan'
        ]);

        
        Product::create([
            'category_id' => $category->id,
            'name' => 'Toyota Camry',
            'description' => 'mobil',
            'price' => 25000.00,
            'stock' => 5
        ]);
    }
}