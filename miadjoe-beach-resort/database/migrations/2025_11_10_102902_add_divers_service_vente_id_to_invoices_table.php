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
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('divers_service_vente_id')->nullable()->after('reservation_id');

            // Optionnel : clé étrangère
            $table->foreign('divers_service_vente_id')
                ->references('id')
                ->on('divers_service_ventes')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['divers_service_vente_id']);
            $table->dropColumn('divers_service_vente_id');
        });
    }
};
