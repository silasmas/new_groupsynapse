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
            $table->string('phone')->nullable()->after('email');
            $table->string('sexe')->nullable()->after('phone');
            $table->string('pays')->nullable()->after('sexe');
            $table->text('adresse')->nullable()->after('pays');
            $table->text('adresse_livraison')->nullable()->after('adresse');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'sexe', 'pays', 'adresse', 'adresse_livraison']);
        });
    }
};
