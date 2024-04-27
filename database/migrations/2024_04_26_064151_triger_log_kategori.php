<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER kategori_deleted AFTER DELETE ON kategori FOR EACH ROW
            BEGIN
                INSERT INTO log_kategori (id_kategori, nama_kategori, created_at, updated_at)
                VALUES (OLD.id, OLD.nama_kategori, NOW(), NOW());
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
