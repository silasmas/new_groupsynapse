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
        Schema::create('service_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');

            // Champs communs
            $table->string('reference')->unique();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->text('adresse')->nullable();
            $table->string('piece_identite')->nullable();
            $table->string('numero_carte')->nullable();   // Pour renouvellement
            $table->string('photo_identite')->nullable(); // Stocker le chemin
            $table->string('adresse_livraison')->nullable();
            $table->string('etat')->default('init'); // initialisé, en cours, terminé, annulé
            $table->string('currency')->default('USD'); // initialisé, en cours, terminé, annulé
            $table->boolean('livraison')->default(false); // Livraison ou non
            $table->decimal('premierDepot', 8, 2)->nullable();
            $table->decimal('montant_depot', 8, 2)->nullable();
            $table->decimal('montantRecharge', 8, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_users');
    }
};
