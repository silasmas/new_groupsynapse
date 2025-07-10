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
        Schema::create('comments', function (Blueprint $table) {
                $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('guest_name')->nullable();
        $table->string('guest_email')->nullable();
        $table->text('body');
        $table->unsignedBigInteger('commentable_id');
        $table->string('commentable_type');
        $table->timestamps();

        // la clé étrangère après avoir créé user_id
        $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
