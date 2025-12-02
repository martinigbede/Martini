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
        // Table sales
        Schema::table('sales', function (Blueprint $table) {
            $table->string('statut')->default('en_attente')->after('id'); // J'ai ajouté after('id') pour l'exemple
        });

        // Table divers_service_ventes
        Schema::table('divers_service_ventes', function (Blueprint $table) {
            $table->string('statut')->default('en_attente')->after('id'); // J'ai ajouté after('id') pour l'exemple
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Table sales
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('statut');
        });

        // Table divers_service_ventes
        Schema::table('divers_service_ventes', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};