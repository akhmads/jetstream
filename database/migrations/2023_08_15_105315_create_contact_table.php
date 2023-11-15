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
        Schema::create('contact', function (Blueprint $table) {
			$table->id();
            $table->string('name', $precision = 50);
            $table->string('type', $precision = 25);
            $table->text('address', $precision = 200);
            $table->string('pic', $precision = 50);
            $table->string('mobile', $precision = 25);
            $table->string('mobile2', $precision = 25);
            $table->string('email', $precision = 50);
            $table->string('nonpwp', $precision = 25);
            $table->string('npwpnm', $precision = 50);
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact');
    }
};
