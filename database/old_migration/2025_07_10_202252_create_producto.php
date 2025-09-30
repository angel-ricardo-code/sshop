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

        Schema::create('producto_temp', function (Blueprint $table) {
            $table->id();
            $table->text('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->integer('precio_compra');
            $table->integer('precio_venta');
            $table->text('categoria')->nullable();
            $table->text('clasificacion')->nullable();
            $table->integer('stock');
            $table->timestamps();
        });


        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->text('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->integer('precio_compra');
            $table->integer('precio_venta');
            $table->text('categoria')->nullable();
            $table->text('clasificacion')->nullable();
            $table->timestamps();
        });

     DB::unprepared('
                        CREATE OR REPLACE FUNCTION add_product()
                        RETURNS TRIGGER
                        AS
                        $$

                    --Declaramos las variables para organizar y evistar redundancias

                        DECLARE id_prod INTEGER;
                        DECLARE nuevo_prod_id INTEGER;


                        BEGIN

                    --Seleccionamos el id si existe.

                        SELECT id INTO id_prod FROM producto WHERE nombre = NEW.nombre LIMIT 1;

                        IF EXISTS(SELECT 1 FROM producto WHERE nombre = NEW.nombre)
                        THEN
                        UPDATE producto SET precio_venta = NEW.precio_venta, precio_compra = NEW.precio_compra, updated_at = NEW.updated_at WHERE id = id_prod;
                        UPDATE inventario SET stock = stock + NEW.stock, updated_at = NEW.updated_at WHERE id_producto = id_prod;
                        INSERT INTO compras (id_producto, cantidad, created_at, updated_at) VALUES (id_prod, NEW.stock, NEW.created_at, NEW.updated_at);


                       ELSE
                       INSERT INTO producto (nombre, descripcion, precio_compra, precio_venta, categoria, created_at, updated_at) VALUES ( NEW.nombre,NEW.descripcion,NEW.precio_compra,NEW.precio_venta,NEW.categoria, NEW.created_at, NEW.updated_at);

                       SELECT id INTO nuevo_prod_id FROM producto WHERE nombre = NEW.nombre LIMIT 1;

                       INSERT INTO inventario (id_producto, stock, created_at, updated_at) VALUES( nuevo_prod_id, NEW.stock, NEW.created_at, NEW.updated_at);

                       INSERT INTO compras (id_producto, cantidad, precio_compra, created_at, updated_at) VALUES( nuevo_prod_id, NEW.stock,NEW.precio_compra, NEW.created_at, NEW.updated_at);



                       END IF;



                       RETURN NEW;

                       END;
                       $$
                       LANGUAGE PLPGSQL;



                       CREATE TRIGGER add_product_trigger BEFORE INSERT ON producto_temp
                       FOR EACH ROW
                       EXECUTE FUNCTION add_product();
                            ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
        Schema::dropIfExists('producto_temp');
    }
};
