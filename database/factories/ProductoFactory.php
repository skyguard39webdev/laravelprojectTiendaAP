<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'marca' => $this->faker->name(),
            'modelo' => $this->faker->name(),
            'titulo' => $this->faker->name(),
            'precio' => $this->faker->randomNumber(2, true),
            'peso' => $this->faker->numberBetween(1, 15),
            'tramos' => $this->faker->numberBetween(1, 4),
            'tramos_mts' => $this->faker->numberBetween(1, 30),
            'pcs' => $this->faker->numberBetween(1, 3),
            'subcat_id' => $this->faker->numberBetween(1, 15),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
