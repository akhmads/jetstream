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
        Schema::create('beginning_balance', function (Blueprint $table) {
            $table->id();
            $table->year('year')->index();
            $table->string('coa_code',20)->index();
            $table->decimal('debit', 12, 2);
            $table->decimal('credit', 12, 2);
            $table->decimal('amount', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beginning_balance');
    }
};
