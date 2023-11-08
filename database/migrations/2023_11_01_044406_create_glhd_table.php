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
        Schema::create('glhd', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->unique();
            $table->date('date')->index();
            $table->string('note',200);
            $table->decimal('debit_total', 12, 2)->default(0);
            $table->decimal('credit_total', 12, 2)->default(0);
            $table->string('ref_name',50)->index()->nullable();
            $table->string('ref_id',50)->index()->nullable();
            $table->integer('contact_id')->index()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glhd');
    }
};
