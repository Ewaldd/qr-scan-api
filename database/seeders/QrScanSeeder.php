<?php

namespace Database\Seeders;

use App\Models\QrScan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QrScanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QrScan::factory(5)->create();
    }
}
