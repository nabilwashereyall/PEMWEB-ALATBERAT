<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('IdStaff')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Set semua NULL menjadi 0 sebelum rollback
        DB::table('invoice')->whereNull('IdStaff')->update(['IdStaff' => 0]);
        
        Schema::table('invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('IdStaff')->nullable(false)->change();
        });
    }
};