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
		Schema::create('favories', function (Blueprint $table) {
        	$table->id();

        	$table->timestamps();
        });

		Schema::table('favories', function (Blueprint $table) {
                    $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
        // Schema::table('favories', function (Blueprint $table) {
                    $table->foreignIdFor(\App\Models\Produit::class)->constrained()->onDelete('cascade');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favories');
    }
};
