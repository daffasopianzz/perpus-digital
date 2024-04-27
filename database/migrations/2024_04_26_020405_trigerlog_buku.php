<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER buku_deleted AFTER DELETE ON buku FOR EACH ROW
            BEGIN
                INSERT INTO log_buku (id_buku, nama_buku, created_at, updated_at)
                VALUES (OLD.id, OLD.judul, NOW(), NOW());
            END
        ');
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS buku_deleted');
    }
};
