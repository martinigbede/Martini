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
        Schema::create('divers_service_vente_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divers_service_vente_id')->constrained()->onDelete('cascade');
            $table->foreignId('divers_service_id')->constrained()->onDelete('cascade');
            $table->enum('mode_facturation', ['personne', 'groupe', 'duree', 'fixe'])->default('fixe');
            $table->integer('quantite')->default(1);
            $table->integer('duree')->nullable(); // pour les locations, en heures ou jours
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('sous_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divers_service_vente_items');
    }
};
