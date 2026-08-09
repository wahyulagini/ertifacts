<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LokasiGeografis;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Candi Borobudur', 'Candi Buddha', 'Magelang', 'Jawa Tengah', 'Candi Buddha terbesar di dunia dari dinasti Syailendra.'],
            ['Candi Prambanan', 'Candi Hindu', 'Sleman', 'DI Yogyakarta', 'Candi Hindu terbesar persembahan Siwa, Wisnu, Brahma.'],
            ['Benteng Rotterdam', 'Benteng', 'Makassar', 'Sulawesi Selatan', 'Benteng peninggalan Gowa-Tallo, dikuasai VOC.'],
            ['Istana Maimun', 'Istana', 'Medan', 'Sumatera Utara', 'Istana kebesaran Kesultanan Deli.'],
            ['Benteng Vredeburg', 'Benteng', 'Yogyakarta', 'DI Yogyakarta', 'Benteng VOC untuk memantau Keraton Yogyakarta.'],
            ['Candi Muara Takus', 'Kompleks Candi', 'Kampar', 'Riau', 'Candi Buddha peninggalan Kerajaan Sriwijaya di Sumatera.'],
            ['Rumah Rengasdengklok', 'Rumah Bersejarah', 'Karawang', 'Jawa Barat', 'Lokasi penculikan Soekarno-Hatta sebelum proklamasi.'],
            ['Lawang Sewu', 'Gedung Bersejarah', 'Semarang', 'Jawa Tengah', 'Bekas kantor pusat NIS, memiliki banyak pintu.'],
            ['Monumen Nasional', 'Monumen', 'Jakarta Pusat', 'DKI Jakarta', 'Tugu peringatan kemerdekaan Republik Indonesia.'],
            ['Museum Nasional', 'Museum', 'Jakarta Pusat', 'DKI Jakarta', 'Museum Gajah, museum arkeologi terbesar.'],
            ['Gedung Sate', 'Gedung Pemerintahan', 'Bandung', 'Jawa Barat', 'Gedung era kolonial berciri khas tusuk sate.'],
            ['Keraton Yogyakarta', 'Istana', 'Yogyakarta', 'DI Yogyakarta', 'Pusat kebudayaan Jawa dan Kesultanan Ngayogyakarta.'],
            ['Keraton Kasepuhan', 'Istana', 'Cirebon', 'Jawa Barat', 'Keraton tertua peninggalan Sunan Gunung Jati.'],
            ['Masjid Agung Demak', 'Masjid', 'Demak', 'Jawa Tengah', 'Masjid tertua peninggalan Wali Songo.'],
            ['Situs Sangiran', 'Situs Prasejarah', 'Sragen', 'Jawa Tengah', 'Situs penemuan manusia purba Homo erectus.'],
            ['Taman Sari', 'Taman Air', 'Yogyakarta', 'DI Yogyakarta', 'Taman air pesanggrahan sultan dan kerabatnya.'],
            ['Benteng Marlborough', 'Benteng', 'Bengkulu', 'Bengkulu', 'Benteng pertahanan Inggris di pesisir Sumatera.'],
            ['Istana Pagaruyung', 'Istana', 'Tanah Datar', 'Sumatera Barat', 'Istana kebesaran Kerajaan Minangkabau.'],
            ['Masjid Menara Kudus', 'Masjid', 'Kudus', 'Jawa Tengah', 'Masjid dengan arsitektur menara Hindu-Islam.'],
            ['Makam Imogiri', 'Kompleks Makam', 'Bantul', 'DI Yogyakarta', 'Makam raja-raja Mataram Islam.'],
            ['Benteng Somba Opu', 'Benteng', 'Gowa', 'Sulawesi Selatan', 'Benteng pertahanan utama Kesultanan Gowa.'],
            ['Museum Fatahillah', 'Museum', 'Jakarta Barat', 'DKI Jakarta', 'Bekas balai kota Batavia.'],
            ['Pelabuhan Sunda Kelapa', 'Pelabuhan Bersejarah', 'Jakarta Utara', 'DKI Jakarta', 'Pelabuhan kuno dari era Pajajaran dan VOC.'],
            ['Gedung Linggarjati', 'Gedung Bersejarah', 'Kuningan', 'Jawa Barat', 'Tempat perundingan Linggarjati RI-Belanda.'],
            ['Candi Penataran', 'Candi Hindu', 'Blitar', 'Jawa Timur', 'Kompleks candi terbesar di Jawa Timur.'],
            ['Masjid Raya Baiturrahman', 'Masjid', 'Banda Aceh', 'Aceh', 'Masjid lambang perjuangan rakyat Aceh.'],
            ['Keraton Surakarta', 'Istana', 'Surakarta', 'Jawa Tengah', 'Pusat pemerintahan Kasunanan Surakarta.'],
            ['Jam Gadang', 'Menara Jam', 'Bukittinggi', 'Sumatera Barat', 'Menara jam hadiah Ratu Belanda.'],
            ['Istana Kadriah', 'Istana', 'Pontianak', 'Kalimantan Barat', 'Istana Kesultanan Pontianak.'],
            ['Benteng Belgica', 'Benteng', 'Banda Neira', 'Maluku', 'Benteng pertahanan VOC di kepulauan rempah.'],
            ['Situs Trowulan', 'Situs Arkeologi', 'Mojokerto', 'Jawa Timur', 'Bekas ibu kota kerajaan Majapahit.'],
            ['Gua Leang-Leang', 'Situs Prasejarah', 'Maros', 'Sulawesi Selatan', 'Gua dengan lukisan tangan manusia purba prasejarah.'],
            ['Kampung Naga', 'Desa Adat', 'Tasikmalaya', 'Jawa Barat', 'Desa pelestari adat leluhur Sunda.'],
            ['Benteng Tolukko', 'Benteng', 'Ternate', 'Maluku Utara', 'Benteng Portugis di atas bukit.'],
            ['Gedung Joang 45', 'Museum', 'Jakarta Pusat', 'DKI Jakarta', 'Tempat para pemuda mempersiapkan kemerdekaan.']
        ];

        foreach ($data as $item) {
            LokasiGeografis::updateOrCreate(
                ['nama_lokasi' => $item[0]],
                [
                    'jenis_lokasi' => 'Lainnya',
                    'kabupaten_kota' => $item[2],
                    'provinsi' => $item[3],
                    'deskripsi' => $item[4],
                    'latitude' => 0.0,
                    'longitude' => 0.0,
                    'periode_sejarah' => 'Sejarah Indonesia',
                    'status_kelola' => 'Aktif Dijaga',
                    'pengelola' => 'Pemerintah Pusat',
                    'jam_operasional' => '08:00 - 16:00',
                    'gambar_path' => 'https://images.unsplash.com/photo-1548625361-185e78342416?auto=format&fit=crop&w=400&q=80'
                ]
            );
        }
    }
}
