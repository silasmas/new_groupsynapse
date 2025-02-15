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
            // $table->string('reference')->unique();
            // $table->boolean('livraison')->nullable();
            // $table->string('commune')->nullable();
            // $table->double('prixLivraison')->nullable();
            // $table->enum('etat', ['En attente', 'Payée', 'En cours', 'Livrée', 'Annulée'])->default('En attente'); // État de la commande
            // $table->double('total', 10, 2); // Prix total de la commande
            // $table->timestamps();
            $table->string('reference')->unique(); // Référence unique pour la commande
            $table->string('provider_reference')->nullable(); // Référence fournie par FlexPay
            $table->double('total', 10, 2); // Montant total de la commande
            $table->double('amount_customer', 10, 2)->nullable(); // Montant payé par le client (avec frais)
            $table->string('currency')->default('CDF'); // Devise de paiement
            $table->enum('channel', ['mobile_money', 'card'])->nullable(); // Canal de paiement
            $table->string('phone')->nullable(); // Commune pour la livraison
            $table->enum('etat', ['En attente', 'Payée', 'En cours', 'Livrée', 'Annulée'])->default('En attente'); // État de la commande
            $table->boolean('livraison')->default(false); // Livraison nécessaire ou non
            $table->string('commune')->nullable(); // Commune pour la livraison
            $table->double('prix_livraison', 10, 2)->nullable(); // Frais de livraison
            $table->text('description')->nullable(); // Description de la commande
            // $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Lien avec l'utilisateur
            $table->timestamps();
        });

        Schema::table('commandes', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
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
