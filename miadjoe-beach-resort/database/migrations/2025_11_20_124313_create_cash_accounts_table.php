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
        Schema::create('cash_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('nom_compte'); // Exemple: Espèces, Mobile Money, Carte/TPE, Virement
            $table->string('type_caisse'); // Exemple: Hébergement, Restaurant
            $table->decimal('solde', 15, 2)->default(0); // Solde actuel
            $table->timestamps();
        });

        // Seed de base
        DB::table('cash_accounts')->insert([
            ['nom_compte'=>'Espèces','type_caisse'=>'Hébergement','solde'=>0],
            ['nom_compte'=>'Mobile Money','type_caisse'=>'Hébergement','solde'=>0],
            ['nom_compte'=>'Carte/TPE','type_caisse'=>'Hébergement','solde'=>0],
            ['nom_compte'=>'Virement','type_caisse'=>'Hébergement','solde'=>0],

            ['nom_compte'=>'Espèces','type_caisse'=>'Restaurant','solde'=>0],
            ['nom_compte'=>'Mobile Money','type_caisse'=>'Restaurant','solde'=>0],
            ['nom_compte'=>'Carte/TPE','type_caisse'=>'Restaurant','solde'=>0],
            ['nom_compte'=>'Virement','type_caisse'=>'Restaurant','solde'=>0],
        ]);
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_accounts');
    }
};
