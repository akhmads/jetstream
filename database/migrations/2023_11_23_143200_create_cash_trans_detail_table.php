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
        Schema::create('cash_trans_detail', function (Blueprint $table) {
            $table->id();
            $table->string('number',50)->index();
            $table->string('coa_code',20)->index();
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('currency',20);
            $table->decimal('rate', 12, 2)->default(1);
            $table->decimal('hamount', 12, 2)->default(0);
            $table->string('note',200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_trans_detail');
    }
};
