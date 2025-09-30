<?php

namespace Database\Seeders;

use App\Models\Producto_temp;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Venta_temp;
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

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        User::create(
            [
                'name' => 'Angel Ricardo',
                'email' => 'angelricardo@gmail.com',
                'password' => Hash::make('12345.An'),
            ]
        );

		User::create (
			[
			'name' => 'Lorena María',
			'email' => 'lore@gmail.com',
			'password' => Hash::make('12345.Lore'),
			]

		);


        User::factory(5)->create();

        Producto_temp::factory(50)->create();

        Venta_temp::factory(5000)->create();
        Venta_temp::factory(50)->create();
    }
}
