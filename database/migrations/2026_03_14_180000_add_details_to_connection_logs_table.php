<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('connection_logs', function (Blueprint $table) {
            $table->timestamp('disconnected_at')->nullable()->after('last_activity_at');
            $table->string('country', 100)->nullable()->after('ip_address');
            $table->json('pages_visited')->nullable()->after('country');
        });
    }

    public function down(): void
    {
        Schema::table('connection_logs', function (Blueprint $table) {
            $table->dropColumn(['disconnected_at', 'country', 'pages_visited']);
        });
    }
};
