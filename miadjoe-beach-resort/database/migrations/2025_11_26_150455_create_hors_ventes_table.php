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
        Schema::create('hors_ventes', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 10, 2);
            $table->string('mode_paiement')->default('Espèces'); // Espèces / Mobile Money / etc.
            $table->string('motif')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hors_ventes');
    }
};
