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
        Schema::table('users', function (Blueprint $table) {
            $table->string('NoTelepon', 15)->nullable()->after('Email');
            $table->text('Alamat')->nullable()->after('NoTelepon');
            $table->string('Kota', 50)->nullable()->after('Alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['NoTelepon', 'Alamat', 'Kota']);
        });
    }
};