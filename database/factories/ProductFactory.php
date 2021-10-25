<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => mt_rand(1,2),
            'sub_category_id' => mt_rand(1,5),
            'name' => $this->faker->name(),
            'slug' => $this->faker->unique()->slug(),
            'size' => "1",
            'description' => $this->faker->sentence(mt_rand(10,20)),
            'price' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'stock' => mt_rand(20,50),
            'photo' => "product/default.jpg",
            'is_active' => 1,
        ];
    }
}