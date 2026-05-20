<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('laundry_weight', 8, 2)->nullable()->after('location');
            $table->unsignedInteger('service_price')->nullable()->after('laundry_weight');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['laundry_weight', 'service_price']);
        });
    }
};
