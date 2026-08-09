<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Data lama
            ['Festival Budaya Nusantara 2026', 'Pameran seni budaya dari seluruh Indonesia, menampilkan tarian dan kuliner khas.', 10, 3, 20, 150000.00, 'mendatang', 'Area Utama Museum'],
            ['Pameran Naskah Kuno dan Manuskrip', 'Pameran eksklusif manuskrip sejarah dari era pra-kolonial.', 14, 7, 10, 200000.00, 'mendatang', 'Area Utama Museum'],
            ['Expo Kuliner Tradisional Museum', 'Bazar kuliner masakan peninggalan kerajaan Nusantara.', -5, 2, 30, 100000.00, 'berjalan', 'Area Utama Museum'],
            ['Pekan Kesenian Daerah', 'Lomba lukis dan tari untuk memperkenalkan sejarah lewat seni.', 30, 3, 15, 120000.00, 'mendatang', 'Area Utama Museum'],

            // 14 data tambahan
            ['Pameran Batik Nusantara', 'Pameran koleksi batik dari berbagai daerah di Indonesia dengan penjelasan makna motif.', 45, 5, 25, 175000.00, 'mendatang', 'Galeri Seni Museum'],
            ['Festival Wayang Kulit Tradisional', 'Pertunjukan wayang kulit semalam suntuk oleh dalang-dalang terbaik dari Jawa dan Bali.', 20, 2, 12, 250000.00, 'mendatang', 'Panggung Terbuka'],
            ['Pameran Arkeologi Prasejarah', 'Pameran temuan fosil dan artefak masa prasejarah Nusantara.', -10, 20, 8, 0.00, 'berjalan', 'Gedung Pameran A'],
            ['Workshop Membatik untuk Pelajar', 'Workshop interaktif membatik khusus pelajar SD dan SMP bersama pengrajin batik senior.', 7, 1, 40, 50000.00, 'mendatang', 'Ruang Workshop'],
            ['Pameran Senjata Tradisional Nusantara', 'Koleksi keris, tombak, dan senjata tradisional dari berbagai kerajaan di Indonesia.', 60, 10, 5, 300000.00, 'mendatang', 'Gedung Pameran B'],
            ['Seminar Sejarah Kerajaan Majapahit', 'Seminar ilmiah menghadirkan pakar sejarah dan arkeolog dari berbagai universitas.', 15, 1, 50, 75000.00, 'mendatang', 'Aula Konferensi'],
            ['Expo Perhiasan Kuno dan Emas Antik', 'Pameran perhiasan emas dan perak dari era kerajaan Hindu-Buddha Nusantara.', -30, 60, 6, 500000.00, 'selesai', 'Ruang Koleksi Khusus'],
            ['Festival Tari Tradisional Nusantara', 'Penampilan tarian tradisional dari 34 provinsi Indonesia oleh sanggar-sanggar terpilih.', 25, 3, 35, 125000.00, 'mendatang', 'Panggung Terbuka'],
            ['Pameran Foto Sejarah Indonesia', 'Koleksi foto dokumenter era kolonial hingga kemerdekaan Indonesia.', -20, 90, 0, 0.00, 'berjalan', 'Lorong Galeri Museum'],
            ['Lomba Desain Batik Digital', 'Kompetisi desain batik berbasis teknologi digital untuk generasi muda.', 35, 2, 0, 0.00, 'mendatang', 'Ruang Workshop'],
            ['Pameran Keramik Kuno Asia Tenggara', 'Koleksi keramik langka dari jalur perdagangan Asia Tenggara abad ke-9 hingga ke-15.', -45, 120, 4, 400000.00, 'selesai', 'Gedung Pameran A'],
            ['Pekan Literasi Sejarah dan Budaya', 'Rangkaian kegiatan membaca, diskusi, dan pameran buku sejarah untuk masyarakat umum.', 50, 7, 20, 80000.00, 'mendatang', 'Perpustakaan Museum'],
            ['Workshop Kaligrafi Arab dan Jawa Kuno', 'Pelatihan kaligrafi aksara Arab pegon dan Jawa Kuno bersama kaligrafer berpengalaman.', 12, 1, 30, 60000.00, 'mendatang', 'Ruang Workshop'],
            ['Pameran Miniatur Kapal Kuno Nusantara', 'Pameran replika kapal-kapal niaga dan armada perang kerajaan maritim Nusantara.', -60, 180, 0, 0.00, 'selesai', 'Gedung Pameran B'],
        ];

        foreach ($data as $item) {
            Event::updateOrCreate(
                ['judul_event' => $item[0]],
                [
                    'deskripsi' => $item[1],
                    'tanggal_mulai' => Carbon::now()->addDays($item[2]),
                    'tanggal_selesai' => Carbon::now()->addDays($item[2] + $item[3]),
                    'lokasi_area' => $item[7],
                    'kuota_tenant' => $item[4],
                    'harga_sewa_booth' => $item[5],
                    'status' => $item[6]
                ]
            );
        }
    }
}
