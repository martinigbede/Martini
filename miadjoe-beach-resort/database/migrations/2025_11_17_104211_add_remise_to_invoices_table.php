<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemiseToInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('remise_percent', 5, 2)->default(0)->after('montant_total');
            $table->decimal('remise_amount', 12, 2)->default(0)->after('remise_percent');
            $table->decimal('montant_final', 12, 2)->default(0)->after('remise_amount');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'remise_percent',
                'remise_amount',
                'montant_final',
            ]);
        });
    }
}
