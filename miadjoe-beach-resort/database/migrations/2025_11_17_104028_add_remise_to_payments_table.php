<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemiseToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('is_remise')->default(false)->after('statut');
            $table->decimal('remise_percent', 5, 2)->nullable()->after('is_remise');
            $table->decimal('remise_amount', 12, 2)->nullable()->after('remise_percent');
            $table->string('motif_remise')->nullable()->after('remise_amount');
            $table->boolean('est_offert')->default(false)->after('motif_remise');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'is_remise',
                'remise_percent',
                'remise_amount',
                'motif_remise',
                'est_offert',
            ]);
        });
    }
}
