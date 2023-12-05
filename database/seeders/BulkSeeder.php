<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BulkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->coa();
        $this->item();
        //$this->customer();
        $this->cash();
        $this->bank();
    }

    public function coa()
    {
        $path = base_path() . '/.BAK/coa_IBS.txt';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Coa table seeded!');
    }

    public function item()
    {
        $path = base_path() . '/.BAK/Item Master IBS.txt';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Items table seeded!');
    }

    public function customer()
    {
        $path = base_path() . '/.BAK/Cust Master IBS.txt';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Customer table seeded!');
    }

    public function bank()
    {
        DB::table('bank')->insert([
            [
                'name' => 'BCA',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'MANDIRI',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'BNI',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'CIMB',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        DB::table('bank_account')->insert([
            [
                'number' => '069-3778899',
                'bank_id' => '1',
                'currency' => 'IDR',
                'coa_code' => '102-001',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'number' => '069-3151888',
                'bank_id' => '1',
                'currency' => 'IDR',
                'coa_code' => '102-002',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'number' => '069-3589999',
                'bank_id' => '1',
                'currency' => 'IDR',
                'coa_code' => '102-003',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

    }

    public function cash()
    {
        DB::table('cash_account')->insert([
            [
                'name' => 'Cash On Hand IDR',
                'currency' => 'IDR',
                'coa_code' => '101-001',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cash On Hand USD',
                'currency' => 'USD',
                'coa_code' => '101-002',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cash On Hand Bdr',
                'currency' => 'IDR',
                'coa_code' => '101-003',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cash On Hand Mkr',
                'currency' => 'IDR',
                'coa_code' => '101-004',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cash On Hand Opr',
                'currency' => 'IDR',
                'coa_code' => '101-005',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cash On Hand Obd',
                'currency' => 'IDR',
                'coa_code' => '101-006',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cash On Hand Owm',
                'currency' => 'IDR',
                'coa_code' => '101-007',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cash Tax Amnesty',
                'currency' => 'IDR',
                'coa_code' => '101-008',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Petty Cash Office',
                'currency' => 'IDR',
                'coa_code' => '101-101',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Petty Cash Office',
                'currency' => 'IDR',
                'coa_code' => '101-101',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Petty Cash Warehouse',
                'currency' => 'IDR',
                'coa_code' => '101-102',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Petty Cash Ga',
                'currency' => 'IDR',
                'coa_code' => '101-102',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Inter Cash',
                'currency' => 'IDR',
                'coa_code' => '101-109',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
