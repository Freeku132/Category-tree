<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $procedure = "DROP PROCEDURE IF EXISTS `DropSubCategory`;
        CREATE DEFINER=`root`@`localhost` PROCEDURE `DropSubCategory`( IN deleted_category_id INT )
        BEGIN
        SET max_sp_recursion_depth=255;

            label1: FOR i IN
            (
                SELECT id
                FROM categories
                WHERE category_parent = deleted_category_id
            )

            DO
                CALL DropSubCategory(i.id);

            END FOR label1;

            DELETE FROM categories
            WHERE id = deleted_category_id;

            COMMIT;

        END
        ";
        \DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
