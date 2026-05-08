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
        Schema::table('login_histories', function (Blueprint $table) {
            // Kita cek dulu supaya tidak bentrok
            if (!Schema::hasColumn('login_histories', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('login_histories', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
