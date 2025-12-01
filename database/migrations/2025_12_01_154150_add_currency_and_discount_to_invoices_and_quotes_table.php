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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('currency')->default('DZD')->after('status');
            $table->decimal('discount', 10, 2)->default(0)->after('total');
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->string('currency')->default('DZD')->after('status');
            $table->decimal('discount', 10, 2)->default(0)->after('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['currency', 'discount']);
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn(['currency', 'discount']);
        });
    }
};
