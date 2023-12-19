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
        Schema::create('res_code', function (Blueprint $table) {
            $table->id();
            $table->string('resource',50)->unique()->index();
            $table->string('code',100);
        });

        DB::table('res_code')->insert([
            [
                'resource' => 'Cash In',
                'code' => 'BKM',
            ],
            [
                'resource' => 'Cash Out',
                'code' => 'BKK',
            ],
            [
                'resource' => 'Bank In',
                'code' => 'BBM',
            ],
            [
                'resource' => 'Bank Out',
                'code' => 'BBK',
            ],
            [
                'resource' => 'Journal Voucher',
                'code' => 'JV',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('res_code');
    }
};
