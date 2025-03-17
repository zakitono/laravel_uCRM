<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'name' => 'カット',
                'memo' => 'カットの詳細',
                'price' => 6000
            ],
            [
                'name' => 'カラー',
                'memo' => 'カラーの詳細',
                'price' => 8000
            ],
            [
                'name' => 'パーマ(カット込)',
                'memo' => 'パーマ、カットの詳細',
                'price' => 13000
            ],
        ]);
    }
}
