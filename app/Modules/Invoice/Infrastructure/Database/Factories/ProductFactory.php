<?php

namespace App\Modules\Invoice\Infrastructure\Database\Factories;

use App\Modules\Invoice\Infrastructure\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
* @extends Factory<Product>
 *
 * @method Product create($attributes = [], ?Model $parent = null)
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(3),
            'currency' => $this->faker->currencyCode(),
        ];
    }
}
