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
		Schema::create('transactions', function (Blueprint $table) {
        	$table->id();
        	$table->string('reference')->unique();
			$table->string('provider_reference')->unique()->nullable();
			$table->string('oreder_number')->nullable();
			$table->string('amount_costumer')->nullable();
			$table->string('currency')->nullable();
			$table->string('chanel')->nullable();
			$table->text('description')->nullable();
			$table->string('etat')->nullable();
        	$table->timestamps();
        });

		Schema::table('transactions', function (Blueprint $table) {
                    $table->foreignIdFor(\App\Models\Commande::class)->constrained()->onDelete('cascade');

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
