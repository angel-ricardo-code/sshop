<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Producto_temp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\producto>
 */
class Producto_tempFactory extends Factory
{

    protected $model = Producto_temp::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->company(),
            'descripcion' => fake()->text(20),
            'precio_compra' => fake()->randomNumber(3 ),
            'precio_venta' => function ($attributes) {

            return $attributes['precio_compra'] + fake()->randomNumber(2);

            },
            'stock' => fake()->randomNumber(3),
            'categoria' => fake()->randomElement(['Comestibles','Electrodomésticos','Gastables','Piezas','Otros']),
            'clasificacion' => fake()->randomElement(['B','M','E',null]),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
