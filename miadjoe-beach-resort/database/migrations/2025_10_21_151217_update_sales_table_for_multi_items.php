<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // 🔹 Supprimer les anciennes colonnes devenues inutiles
            if (Schema::hasColumn('sales', 'menu_id')) {
                $table->dropConstrainedForeignId('menu_id');
            }

            if (Schema::hasColumn('sales', 'quantite')) {
                $table->dropColumn('quantite');
            }

            if (Schema::hasColumn('sales', 'prix_unitaire')) {
                $table->dropColumn('prix_unitaire');
            }

            if (Schema::hasColumn('sales', 'room_id')) {
                $table->dropConstrainedForeignId('room_id');
            }

            // 🔹 Ajouter la nouvelle clé étrangère vers réservation si elle n’existe pas déjà
            if (!Schema::hasColumn('sales', 'reservation_id')) {
                $table->foreignId('reservation_id')
                      ->nullable()
                      ->constrained('reservations')
                      ->onDelete('set null')
                      ->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Restaurer les anciennes colonnes si rollback
            if (!Schema::hasColumn('sales', 'menu_id')) {
                $table->foreignId('menu_id')->nullable()->constrained('menus')->onDelete('restrict');
            }

            if (!Schema::hasColumn('sales', 'quantite')) {
                $table->integer('quantite')->nullable();
            }

            if (!Schema::hasColumn('sales', 'prix_unitaire')) {
                $table->decimal('prix_unitaire', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('sales', 'room_id')) {
                $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            }

            if (Schema::hasColumn('sales', 'reservation_id')) {
                $table->dropConstrainedForeignId('reservation_id');
            }
        });
    }
};
