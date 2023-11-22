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
        Schema::create('bank', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->index();
            $table->enum('status', ['active','inactive']);
            $table->timestamps();
        });

        $now = Illuminate\Support\Carbon::now();
        DB::table('bank')->insert([
            [
                'name' => 'BCA',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'MANDIRI',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'BNI',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'CIMB',
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
        Schema::dropIfExists('bank');
    }
};
