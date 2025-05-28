<?php

use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->integer('active')->default(0);
            $table->string('image')->nullable();
			$table->integer('disponible')->default(1);
			$table->string('prix')->nullable();
			$table->string('currency')->nullable();
            $table->timestamps();
        });
        Schema::table('services', function (Blueprint $table) {
                      $table->foreignIdFor(\App\Models\Category::class)->constrained()->onDelete('cascade');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
