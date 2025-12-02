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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                ->constrained('clients')
                ->onDelete('cascade');

            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedTinyInteger('nb_personnes');
            $table->boolean('lit_dappoint')->default(false);
            $table->string('statut')->default('En attente'); // En attente, Confirmée, Annulée
            $table->string('mode_reservation')->default('Interne');
            $table->decimal('total', 10, 2)->default(0.00);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
