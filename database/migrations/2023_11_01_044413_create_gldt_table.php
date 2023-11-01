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
        Schema::create('gldt', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->index();
            $table->string('coa_code',20)->index();
            $table->string('description',200)->nullable();
            $table->string('dc',20);
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
        Schema::dropIfExists('gldt');
    }
};
