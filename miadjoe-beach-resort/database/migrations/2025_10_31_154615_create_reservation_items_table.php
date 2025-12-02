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
        Schema::create('reservation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')
                ->constrained('reservations')
                ->onDelete('cascade');

            $table->foreignId('room_id')
                ->constrained('rooms')
                ->onDelete('restrict');

            $table->unsignedInteger('quantite')->default(1);
            $table->unsignedTinyInteger('nb_personnes')->default(1);
            $table->boolean('lit_dappoint')->default(false);

            $table->decimal('prix_unitaire', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_items');
    }
};
