<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
        {
            Schema::table('login_histories', function (Blueprint $table) {
                $table->string('ip_address')->nullable()->after('user_id');
                $table->text('user_agent')->nullable()->after('ip_address');
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login_histories', function (Blueprint $table) {
            //
        });
    }
};
