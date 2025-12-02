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
        Schema::create('cash_account_transactions', function (Blueprint $table) {
            $table->id();

            // Lien vers cash_accounts
            $table->unsignedBigInteger('cash_account_id');
            $table->foreign('cash_account_id')->references('id')->on('cash_accounts')->onDelete('cascade');

            // Montant du mouvement
            $table->decimal('montant', 15, 2);

            // Type de mouvement : entrée (+) ou sortie (-)
            $table->enum('type_operation', ['entree', 'sortie']);

            // Motif ou note
            $table->string('motif')->nullable();

            // Lien vers l'utilisateur qui effectue le mouvement
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_account_transactions');
    }
};
