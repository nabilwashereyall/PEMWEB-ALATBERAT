<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('PendingOrderDetail', function (Blueprint $table) {
            $table->string('Account', 50)->nullable()->after('IdAlatBerat');
        });
    }

    public function down(): void
    {
        Schema::table('PendingOrderDetail', function (Blueprint $table) {
            $table->dropColumn('Account');
        });
    }
};