<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE FUNCTION update_order_total_price()
            RETURNS TRIGGER AS $$
            BEGIN
            
                UPDATE orders
                SET total_price = COALESCE(
                    (
                        SELECT SUM(dishes.price * dishes.quantity)
                        FROM dishes
                        INNER JOIN dish_order ON dish_order.dish_id = dishes.id
                        WHERE dish_order.order_id = orders.id
                    ),
                    0
                )
                WHERE id IN (
                    COALESCE(NEW.order_id, OLD.order_id), 
                    COALESCE(OLD.order_id, NEW.order_id)
                );

                RETURN NULL;
            END
            $$ LANGUAGE plpgsql;;

            CREATE TRIGGER update_order_total_price_trigger
            AFTER INSERT OR UPDATE OR DELETE
            ON dish_order
            FOR EACH ROW
            EXECUTE FUNCTION update_order_total_price();
        SQL);
    }
    

    public function down(): void { DB::unprepared('DROP TRIGGER IF EXISTS after_dish_order_insert'); }
};