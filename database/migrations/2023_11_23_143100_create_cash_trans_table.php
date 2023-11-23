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
        Schema::create('cash_trans', function (Blueprint $table) {
            $table->id();
            $table->string('number',50)->unique()->index();
            $table->string('ref_number',100)->nullable()->default("");
            $table->date('date');
            $table->foreignId('contact_id')->index();
            $table->foreignId('cash_account_id')->index();
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('note',200)->nullable()->default("");
            $table->enum('type', ['in','out'])->index();
            $table->enum('status', ['unapprove','approve','void'])->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_trans');
    }
};
