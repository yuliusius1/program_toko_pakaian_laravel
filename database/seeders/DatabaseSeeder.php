<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'User Yulius',
            'email' => 'yiyus49@gmail.com',
            'password' => bcrypt('1234'),
            'photo' => 'profile/default.jpg',
            'role_id' => 1,
            'is_active' => 1,
        ]);

        User::create([
            'name' => 'Admin Yulius',
            'email' => 'yiyus58@gmail.com',
            'password' => bcrypt('1234'),
            'photo' => 'profile/default.jpg',
            'role_id' => 2,
            'is_active' => 1,
        ]);

        Role::create([
            'role_name' => 'Member',
        ]);

        Role::create([
            'role_name' => 'Admin',
        ]);

        Category::create([
            'category_name' => 'Pakaian Pria',
            'slug' => 'male-category',
            'is_active' => 1,
        ]);

        Category::create([
            'category_name' => 'Pakaian Wanita',
            'slug' => 'female-category',
            'is_active' => 1,
        ]);

        SubCategory::create([
            'category_id' => 2,
            'sub_category_name' => 'Daster',
            'slug' => 'female-category-daster',
            'is_active' => 1,
        ]);

        

        SubCategory::create([
            'category_id' => 1,
            'sub_category_name' => 'Jeans',
            'slug' => 'male-category-jeans',
            'is_active' => 1,
        ]);

        SubCategory::create([
            'category_id' => 1,
            'sub_category_name' => 'Jacket',
            'slug' => 'male-category-jacket',
            'is_active' => 1,
        ]);

        SubCategory::create([
            'category_id' => 1,
            'sub_category_name' => 'Hoodie',
            'slug' => 'male-category-hoodie',
            'is_active' => 1,
        ]);

    }
}