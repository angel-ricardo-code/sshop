<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\venta>
 */
class Venta_tempFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id_productos = Producto::all()->pluck('id')->toArray();
        $idsUsers = User::all()->pluck('id')->toArray();

        return [
            'id_producto' => $this->faker->randomElement($id_productos),
            'id_usuario' => $this->faker->randomElement($idsUsers),
            'cantidad' => $this->faker->randomNumber(2),
            'precio_venta' =>  function (array $attributes) {

                $precio = Producto::find($attributes['id_producto'])->precio_venta;

                $rand = random_int(0,100);

                return $precio + $rand;
            },
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')

        ];
    }
}
