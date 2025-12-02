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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique(); // Numéro de chambre
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade'); // Relation avec RoomType
            $table->enum('statut', ['Libre', 'Occupée', 'Nettoyage', 'Maintenance'])->default('Libre'); // Statut
            $table->text('description')->nullable();
            $table->decimal('prix_personnalise', 10, 2)->nullable(); // Prix surchargé si nécessaire
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
