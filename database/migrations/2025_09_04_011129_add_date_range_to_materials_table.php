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
        Schema::table('materials', function (Blueprint $table) {
            // Menambahkan kolom untuk rentang tanggal kegiatan
            $table->date('activity_date_start')->nullable()->after('activity_date');
            $table->date('activity_date_end')->nullable()->after('activity_date_start');
            
            // Menambahkan index untuk performa query
            $table->index(['activity_date_start', 'activity_date_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropIndex(['activity_date_start', 'activity_date_end']);
            $table->dropColumn(['activity_date_start', 'activity_date_end']);
        });
    }
};