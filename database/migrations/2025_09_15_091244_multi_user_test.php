<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Crear productos

        Schema::create('producto_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->text('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('precio_compra');
            $table->integer('precio_venta');
            $table->text('categoria')->nullable();
            $table->text('clasificacion')->nullable();
            $table->integer('stock');
            $table->primary(['id_usuario', 'id']);
            $table->timestamps();
        });


        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
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
                        UPDATE producto SET precio_venta = NEW.precio_venta, precio_compra = NEW.precio_compra, updated_at = NEW.updated_at WHERE id = id_prod AND id_usuario = NEW.id_usuario;

                        UPDATE inventario SET stock = stock + NEW.stock, updated_at = NEW.updated_at WHERE id_producto = id_prod AND id_usuario = NEW.id_usuario;

                        INSERT INTO compras (id_producto, id_usuario, precio_compra, cantidad, created_at, updated_at) VALUES (id_prod, NEW.id_usuario, NEW.precio_compra, NEW.stock, NEW.created_at, NEW.updated_at);


                       ELSE
                       INSERT INTO producto (nombre, id_usuario, descripcion, precio_compra, precio_venta, categoria, created_at, updated_at) VALUES ( NEW.nombre, NEW.id_usuario ,NEW.descripcion,NEW.precio_compra,NEW.precio_venta,NEW.categoria, NEW.created_at, NEW.updated_at);

                       SELECT id INTO nuevo_prod_id FROM producto WHERE nombre = NEW.nombre LIMIT 1;

                       INSERT INTO inventario (id_producto, id_usuario, stock, created_at, updated_at) VALUES( nuevo_prod_id, NEW.id_usuario, NEW.stock, NEW.created_at, NEW.updated_at);

                       INSERT INTO compras (id_producto, id_usuario, cantidad, precio_compra, created_at, updated_at) VALUES( nuevo_prod_id, NEW.id_usuario, NEW.stock,NEW.precio_compra, NEW.created_at, NEW.updated_at);



                       END IF;



                       RETURN NEW;

                       END;
                       $$
                       LANGUAGE PLPGSQL;



                       CREATE TRIGGER add_product_trigger BEFORE INSERT ON producto_temp
                       FOR EACH ROW
                       EXECUTE FUNCTION add_product();
                            ');


        //Crear el inventario

        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->constrained('producto')->cascadeOnDelete();
            $table->foreignId('id_usuario')->constrained('users')->cascadeOnDelete();
            $table->integer('stock');
            $table->timestamps();
        });

        //Crear la tabla de compras
        /*
         *
         * TODO
         *   Imprementar la relacion id_producto, id_usuario
         *
         *
         *
         * */

        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->constrained('producto')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('users')->cascadeOnDelete();
            $table->integer('cantidad');
            $table->decimal('precio_compra');
            $table->timestamps();
        });

        //Crear la tabla de ventas
        Schema::create('ventas_temp', function (Blueprint $table) {

            $table->id();
            $table->foreignId('id_producto')->constrained('producto')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('users')->cascadeOnDelete();
            $table->bigInteger('cantidad');
            $table->decimal('precio_venta', 8, 2);
            $table->timestamps();
        });


        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->constrained('producto')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('users')->cascadeOnDelete();
            $table->integer('cantidad');
            $table->decimal('precio_venta', 8, 2);
            $table->decimal('monto_venta', 8, 2);
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



        SELECT i.id_producto, i.stock INTO id_prod, inventario_producto FROM inventario i WHERE NEW.id_producto = i.id_producto AND id_usuario = NEW.id_usuario;

        IF (NEW.cantidad <= inventario_producto)
         THEN
          UPDATE inventario SET stock = stock-NEW.cantidad WHERE inventario.id_producto = id_prod  AND id_usuario = NEW.id_usuario;
          INSERT INTO ventas (id_producto, id_usuario, cantidad,precio_venta, monto_venta, created_at, updated_at) VALUES (NEW.id_producto, NEW.id_usuario, NEW.cantidad, NEW.precio_venta, (NEW.cantidad * NEW.precio_venta), NEW.created_at, NOW());


        END IF;

        RETURN NEW;
        END;
        $$
        LANGUAGE plpgsql;

       CREATE TRIGGER sell_product
       BEFORE INSERT ON ventas_temp FOR EACH ROW
       EXECUTE FUNCTION sell_product();



        ");


        //Vistas Necesarias
        /*
         * -Inventario para usuario
         * -Ventas para usuario
         * -Ultimas ventas para el usuario
         *-Productos para el usuario
         * -Productos disponibles para el usuario
         * -
         *
         *
         *
         *
         */


        //Funcion para obtener una tabla con las ventas de cada usuario
        DB::unprepared("

        DROP FUNCTION IF EXISTS user_ventas(INT);

        CREATE OR REPLACE FUNCTION user_ventas(user_id INT)

         RETURNS TABLE (
          id_producto BIGINT,
          cantidad INT,
          precio_venta DECIMAL,
          monto_venta DECIMAL,
          created_at TIMESTAMP,
          updated_at TIMESTAMP
          )

          AS $$

          BEGIN

            RETURN QUERY
            SELECT
              v.id_producto,
              v.cantidad,
              v.precio_venta,
              v.monto_venta,
              v.created_at,
              v.updated_at

            FROM ventas v
            WHERE v.id_usuario = user_id;

          END;

           $$
            LANGUAGE plpgsql;
              ");

        //Funcion para obtener una tabla de inventario para cada usuario
        DB::unprepared("

        DROP FUNCTION IF EXISTS user_inventario(BIGINT);


        CREATE OR REPLACE FUNCTION user_inventario(user_id BIGINT)
        RETURNS TABLE (
        id_producto BIGINT,
        nombre_producto TEXT,
        stock INT,
        precio_compra INT,
        precio_venta INT,
        descripcion TEXT,
        categoria TEXT
        )

        AS
        $$
         BEGIN

         RETURN QUERY

         SELECT p.id, p.nombre, i.stock, p.precio_compra,p.precio_venta, p.descripcion, p.categoria
         FROM producto p, inventario i
         WHERE i.id_producto = p.id AND i.id_usuario = user_id
         ORDER BY p.nombre;

        END;
        $$

         LANGUAGE plpgsql;

        ");

        //Obtener la lista de productos para el usuario y los ids seleccionados
        DB::unprepared("

        DROP FUNCTION IF EXISTS user_productos(INT,INT[]);

         CREATE OR REPLACE FUNCTION user_productos(user_id INT, productos_id INT[] )
         RETURNS TABLE
         (
           id_producto BIGINT,
           nombre TEXT,
           categoria TEXT,
           descripcion TEXT,
           precio_compra INT,
           precio_venta INT,
           stock INT
         )
         AS
         $$
          BEGIN
            RETURN QUERY
            SELECT p.id, p.nombre, p.categoria, p.descripcion, p.precio_compra, p.precio_venta, i.stock as stock
            FROM producto p, inventario i
            WHERE (p.id_usuario = user_id AND p.id = ANY(productos_id)) AND p.id = i.id_producto;
          END;
         $$
         LANGUAGE plpgsql;
         ");

        //Función para obtener la lista de compras por usuario
        DB::unprepared(
            "

                CREATE OR REPLACE FUNCTION user_compras(user_id INT)
                RETURNS TABLE
                 (
                id_producto BIGINT,
                cantidad INT,
                precio_compra DECIMAL,
                created_at TIMESTAMP,
                updated_at TIMESTAMP
                )

                AS $$
                BEGIN
                RETURN QUERY

                SELECT
                c.id_producto,
                c.cantidad,
                c.precio_compra,
                c.created_at,
                c.updated_at

                FROM compras c
                WHERE c.id_usuario = user_id;

                END;
                $$
                LANGUAGE plpgsql;
                ");


        //Probando el git


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //

        DB::unprepared('DROP FUNCTION IF EXISTS user_ventas(INT)');
        Schema::dropIfExists('producto_temp');
        Schema::dropIfExists('producto');
        Schema::dropIfExists('inventario');
        Schema::dropIfExists('compras');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('ventas_temp');
    }
};
