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
        //
        DB::unprepared("

        DROP FUNCTION IF EXISTS holt_level(INT, INT, INT);

        CREATE OR  REPLACE FUNCTION holt_level( user_id INT,  prod_id INT,  year INT)
        RETURNS TABLE (

        month INT,
        total_vendido BIGINT,
        years NUMERIC

        )
        AS
        $$
            BEGIN
             RETURN QUERY

                SELECT id as months, COALESCE(SUM(v.cantidad), 0) as total_vendido, EXTRACT(YEAR from v.created_at) as years FROM calendar
                      LEFT JOIN user_ventas(user_id) v
                      ON calendar.id = EXTRACT(MONTH from v.created_at) AND id_producto = prod_id AND  EXTRACT(YEAR from v.created_at) = year
                GROUP BY EXTRACT(MONTH from v.created_at), calendar.id, EXTRACT(YEAR from v.created_at)
                ORDER BY calendar.id,EXTRACT(YEAR from v.created_at);

            END;
        $$
        LANGUAGE plpgsql;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
