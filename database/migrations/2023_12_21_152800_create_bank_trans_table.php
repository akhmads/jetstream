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
        Schema::create('bank_trans', function (Blueprint $table) {
            $table->id();
            $table->string('code',50)->unique()->index();
            $table->string('ref_code',100)->nullable()->default("");
            $table->date('date');
            $table->foreignId('contact_id')->index();
            $table->foreignId('bank_account_id')->index();
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('note',200)->nullable()->default("");
            $table->enum('type', ['in','out'])->index();
            $table->enum('status', ['unapprove','approve','void'])->index()->default('unapprove');
            $table->foreignId('created_by')->index()->nullable()->default(0);
            $table->foreignId('updated_by')->index()->nullable()->default(0);
            $table->foreignId('approved_by')->index()->nullable()->default(0);
            $table->foreignId('voided_by')->index()->nullable()->default(0);
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('voided_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_trans');
    }
};
