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
        Schema::create('cash_account', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->index();
            $table->string('currency',20);
            $table->string('coa_code',20)->index();
            $table->enum('status', ['active','inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_account');
    }
};
