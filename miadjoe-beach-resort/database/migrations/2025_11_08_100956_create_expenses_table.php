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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('categorie');
            $table->text('description')->nullable();
            $table->enum('mode_paiement', ['espèces', 'mobile money', 'banque', 'Cheque'])->default('espèces');
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('statut', ['en attente', 'validée'])->default('validée');
            $table->decimal('montant', 12, 2);
            $table->date('date_depense');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
