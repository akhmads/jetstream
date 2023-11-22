<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->index();
            $table->string('name',50)->index();
            $table->enum('status', ['active','inactive'])->index();
            $table->timestamps();
        });

        $now = Illuminate\Support\Carbon::now();
        DB::table('currency')->insert([
            [
                'code' => 'IDR',
                'name' => 'Indonesian Rupiah',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'SGD',
                'name' => 'Singapore Dollar',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency');
    }
};
