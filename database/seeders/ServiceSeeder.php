<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            [
                'name' => 'Aplikasi Pengelolaan Keuangan',
                'category' => 'aplikasi',
                'link' => 'https://example.com/aplikasi-keuangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aplikasi Manajemen Proyek',
                'category' => 'aplikasi',
                'link' => 'https://example.com/aplikasi-manajemen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pengaturan Jaringan LAN',
                'category' => 'jaringan',
                'link' => 'https://example.com/jaringan-lan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Konfigurasi Jaringan Wireless',
                'category' => 'jaringan',
                'link' => 'https://example.com/jaringan-wireless',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pemecahan Masalah Sistem',
                'category' => 'troubleshoot',
                'link' => 'https://example.com/troubleshoot-sistem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Panduan Pemecahan Masalah Perangkat',
                'category' => 'troubleshoot',
                'link' => 'https://example.com/troubleshoot-perangkat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
