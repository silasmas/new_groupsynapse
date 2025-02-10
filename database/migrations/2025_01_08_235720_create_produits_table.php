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
		Schema::create('produits', function (Blueprint $table) {
        	$table->id();
        	$table->string('name');
			$table->string('slug');
			$table->text('description');
			$table->text('moreDescription');
			$table->longtext('additionalInfos')->nullable();
			$table->integer('stock');
			$table->string('prix');
			$table->string('currency');
			$table->integer('soldePrice')->nullable();
			$table->json('imageUrls');
			$table->string('brand')->nullable();
			$table->boolean('isAvalable');
			$table->boolean('isBestseler');
			$table->boolean('isNewArivale');
			$table->boolean('isFeatured');
			$table->boolean('isSpecialOffer');
        	$table->timestamps();
        });

		Schema::create('category_produit', function (Blueprint $table) {
                    $table->foreignIdFor(\App\Models\Produit::class)->constrained()->onDelete('cascade');
                    $table->foreignIdFor(\App\Models\Category::class)->constrained()->onDelete('cascade');
                    $table->primary(['produit_id','category_id']);
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
