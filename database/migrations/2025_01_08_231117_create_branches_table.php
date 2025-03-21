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
		Schema::create('branches', function (Blueprint $table) {
        	$table->id();
        	$table->string('name');
			$table->string('slug');
			$table->integer('position');
			$table->text('description');
			$table->boolean('isActive')->nullable();
			$table->string('vignette');
        	$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
