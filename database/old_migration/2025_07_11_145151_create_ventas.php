<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create( 'ventas_temp', function ( Blueprint $table ) {

            $table->id();
            $table->foreignId('id_producto')->constrained('producto')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_venta', 8,2);
            $table->timestamps();
        });





        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->constrained('producto')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_venta', 8,2);
            $table->decimal('monto_venta', 8,2);
            $table->timestamps();
        });

        DB::unprepared("ALTER TABLE ventas_temp ADD CONSTRAINT check_cantidad CHECK ('cantidad' <= 'inventario_producto');");

        //Pendiente hacer un check del precio, en la BD
        //DB::unprepared("ALTER TABLE ventas_temp ADD CONSTRAINT check_precio CHECK ('precio_venta' > 0.00::numeric) ");

        //Trigger para disminuir la cantidad en el inventario
        DB::unprepared("

        CREATE OR REPLACE FUNCTION sell_product()
        RETURNS TRIGGER
        AS
        $$
        DECLARE id_prod INTEGER;
        DECLARE inventario_producto INTEGER;

        BEGIN

        SELECT i.id_producto, i.stock INTO id_prod, inventario_producto FROM inventario i WHERE NEW.id_producto = i.id_producto;

        IF (NEW.cantidad <= inventario_producto)
         THEN
          UPDATE inventario SET stock = stock-NEW.cantidad WHERE inventario.id_producto = id_prod;
          INSERT INTO ventas (id_producto, cantidad,precio_venta, monto_venta, created_at, updated_at) VALUES (NEW.id_producto, NEW.cantidad, NEW.precio_venta, (NEW.cantidad * NEW.precio_venta), NEW.created_at, NOW());


        END IF;

        RETURN NEW;
        END;
        $$
        LANGUAGE plpgsql;

       CREATE TRIGGER sell_product
       BEFORE INSERT ON ventas_temp FOR EACH ROW
       EXECUTE FUNCTION sell_product();



        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('ventas_temp');
    }
};
