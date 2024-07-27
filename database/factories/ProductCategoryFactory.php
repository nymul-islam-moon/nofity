<?php

namespace Database\Factories;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory
{

    public function name()
    {
        return $this->faker->name();
    }

    public function slug()
    {
        $product_category_name = $this->name();

        $categoryArr = explode(' ', $product_category_name);

        $slug_name = '';

        foreach ($categoryArr as $key=> $value)
        {
            $slug_name = $slug_name . '_' . $value;
        }

        return $slug_name;
    }


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "code" => 'PRO_CAT-' . uniqid(),
            "name" => $this->name(),
            "slug" => $this->slug(),
        ];
    }
}
