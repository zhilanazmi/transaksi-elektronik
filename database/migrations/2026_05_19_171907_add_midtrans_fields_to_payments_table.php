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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('midtrans_order_id')->nullable()->unique()->after('invoice_number');
            $table->string('midtrans_transaction_id')->nullable()->after('midtrans_order_id');
            $table->string('midtrans_payment_type')->nullable()->after('midtrans_transaction_id');
            $table->string('midtrans_transaction_status')->nullable()->after('midtrans_payment_type');
            $table->string('midtrans_fraud_status')->nullable()->after('midtrans_transaction_status');
            $table->string('snap_token')->nullable()->after('midtrans_fraud_status');
            $table->text('snap_redirect_url')->nullable()->after('snap_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique(['midtrans_order_id']);
            $table->dropColumn([
                'midtrans_order_id',
                'midtrans_transaction_id',
                'midtrans_payment_type',
                'midtrans_transaction_status',
                'midtrans_fraud_status',
                'snap_token',
                'snap_redirect_url',
            ]);
        });
    }
};
