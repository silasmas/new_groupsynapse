<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('transaction_logs', function (Blueprint $table) {
        $table->id();
        $table->string('reference');
        $table->string('status')->nullable();
        $table->text('message')->nullable();
        $table->string('ip')->nullable();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
