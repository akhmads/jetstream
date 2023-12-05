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
			$table->string('contact_code',30);
			$table->string('contact_type',30)->nullable();
            $table->string('name',50);
            $table->string('type',30)->nullable();
            $table->text('address',200)->nullable();
            $table->string('pic',50)->nullable();
            $table->string('mobile',30)->nullable();
            $table->string('mobile2',30)->nullable();
            $table->string('email',100)->nullable();
            $table->string('nonpwp',30)->nullable();
            $table->string('npwpnm',100)->nullable();
            $table->enum('status', ['active','inactive']);
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
