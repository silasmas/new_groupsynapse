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
		Schema::create('categories', function (Blueprint $table) {
        	$table->id();
        	$table->string('name');
			$table->string('slug')->unique();
			$table->text('description');
			$table->int('type')->default('produit'); // 'default', 'service', 'product', etc.
			$table->string('vignette');
			$table->boolean('isActive');
        	$table->timestamps();
        });

		Schema::table('categories', function (Blueprint $table) {
                    $table->foreignIdFor(\App\Models\Branche::class)->constrained()->onDelete('cascade');

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
