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
		Schema::create('commandes', function (Blueprint $table) {
        	$table->id();
        	$table->string('reference')->unique();
			$table->boolean('livraison')->nullable();
			$table->string('commune')->nullable();
			$table->double('prixLivraison')->nullable();
            $table->enum('etat', ['En attente', 'Payée', 'En cours', 'Livrée', 'Annulée'])->default('En attente'); // État de la commande
            $table->double('total', 10, 2); // Prix total de la commande
        	$table->timestamps();
        });

		Schema::table('commandes', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
        });

        Schema::create('commande_produit', function (Blueprint $table) {
            $table->id(); // ID unique pour la ligne pivot
            $table->foreignId('commande_id')->constrained()->onDelete('cascade'); // Lien vers la commande
            $table->foreignId('produit_id')->constrained()->onDelete('cascade'); // Lien vers le produit

            $table->integer('quantite'); // Quantité du produit dans la commande
            $table->double('prix_unitaire', 10, 2); // Prix unitaire du produit
            $table->double('prix_total', 10, 2); // Prix total (quantité x prix unitaire)
            $table->timestamps(); // created_at et updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
