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
        Schema::table('disbursements', function (Blueprint $table) {
            $table->boolean('est_encaisse')->default(false)->after('montant');
            $table->unsignedBigInteger('encaisse_user_id')->nullable()->after('est_encaisse');
            $table->timestamp('encaisse_at')->nullable()->after('encaisse_user_id');

            $table->index(['reservation_id', 'est_encaisse']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->dropIndex(['reservation_id', 'est_encaisse']);
            $table->dropColumn(['est_encaisse', 'encaisse_user_id', 'encaisse_at']);
        });
    }
};
