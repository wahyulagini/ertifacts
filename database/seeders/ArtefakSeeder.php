<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artefak;

class ArtefakSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['ART-101', 'Prasasti Yupa', 'Kutai Martadipura', 'Abad ke-4 M', 'Epigrafi', 'Kalimantan Timur', 'Batu Andesit', 'Prasasti tertua di Indonesia peninggalan Kerajaan Kutai.'],
            ['ART-102', 'Keris Mpu Gandring', 'Singhasari', 'Abad ke-13 M', 'Senjata', 'Jawa Timur', 'Besi Tempa', 'Keris legendaris yang dikutuk Mpu Gandring.'],
            ['ART-103', 'Arca Prajnaparamita', 'Singhasari', 'Abad ke-13 M', 'Arca', 'Malang', 'Batu Andesit', 'Arca perwujudan kebijaksanaan abadi.'],
            ['ART-104', 'Mahkota Binokasih', 'Pajajaran', 'Abad ke-16 M', 'Perhiasan', 'Jawa Barat', 'Emas', 'Mahkota lambang kekuasaan kerajaan Sunda.'],
            ['ART-105', 'Prasasti Ciaruteun', 'Tarumanegara', 'Abad ke-5 M', 'Epigrafi', 'Bogor', 'Batu Andesit', 'Prasasti dengan telapak kaki Raja Purnawarman.'],
            ['ART-106', 'Kitab Sutasoma', 'Majapahit', 'Abad ke-14 M', 'Manuskrip', 'Jawa Timur', 'Daun Lontar', 'Kakawin karangan Mpu Tantular, asal Bhinneka Tunggal Ika.'],
            ['ART-107', 'Nekara Pejeng', 'Zaman Perunggu', 'Abad ke-3 SM', 'Alat Musik Kuno', 'Bali', 'Perunggu', 'Gendang perunggu terbesar di Asia Tenggara.'],
            ['ART-108', 'Prasasti Kebon Kopi', 'Tarumanegara', 'Abad ke-5 M', 'Epigrafi', 'Bogor', 'Batu', 'Prasasti bergambar tapak kaki gajah Airawata.'],
            ['ART-109', 'Arca Ganesha', 'Kediri', 'Abad ke-11 M', 'Arca', 'Jawa Timur', 'Batu', 'Dewa ilmu pengetahuan.'],
            ['ART-110', 'Prasasti Canggal', 'Mataram Kuno', 'Abad ke-8 M', 'Epigrafi', 'Jawa Tengah', 'Batu', 'Berisi pujian kepada Dewa Siwa.'],
            ['ART-111', 'Stempel Kerajaan Sriwijaya', 'Sriwijaya', 'Abad ke-9 M', 'Sigilografi', 'Sumatera Selatan', 'Emas', 'Stempel kebesaran kerajaan.'],
            ['ART-112', 'Pedang Jenawi', 'Kesultanan Riau', 'Abad ke-17 M', 'Senjata', 'Riau', 'Besi', 'Senjata para panglima perang.'],
            ['ART-113', 'Mandau Pusaka', 'Suku Dayak', 'Abad ke-18 M', 'Senjata', 'Kalimantan', 'Besi & Tulang', 'Senjata khas masyarakat Dayak.'],
            ['ART-114', 'Prasasti Tugu', 'Tarumanegara', 'Abad ke-5 M', 'Epigrafi', 'Jakarta', 'Batu', 'Catatan pembangunan saluran air.'],
            ['ART-115', 'Koin Emas Majapahit', 'Majapahit', 'Abad ke-14 M', 'Numismatika', 'Trowulan', 'Emas', 'Alat tukar resmi kerajaan.'],
            ['ART-116', 'Batik Keraton Yogyakarta', 'Kesultanan Yogyakarta', 'Abad ke-18 M', 'Kain Tradisional', 'Yogyakarta', 'Kain', 'Kain batik motif larangan.'],
            ['ART-117', 'Arca Joko Dolog', 'Singhasari', 'Abad ke-13 M', 'Arca', 'Surabaya', 'Batu', 'Perwujudan Raja Kertanegara.'],
            ['ART-118', 'Keris Kyai Sengkelat', 'Demak', 'Abad ke-15 M', 'Senjata', 'Jawa Tengah', 'Besi Tempa', 'Keris peninggalan masa transisi Hindu ke Islam.'],
            ['ART-119', 'Cincin Stempel Majapahit', 'Majapahit', 'Abad ke-14 M', 'Perhiasan', 'Jawa Timur', 'Emas', 'Cincin dengan lambang Surya Majapahit.'],
            ['ART-120', 'Prasasti Kedukan Bukit', 'Sriwijaya', 'Abad ke-7 M', 'Epigrafi', 'Palembang', 'Batu', 'Bukti awal berdirinya Sriwijaya.'],
            ['ART-121', 'Moko Alor', 'Zaman Perunggu', 'Abad ke-1 SM', 'Alat Musik', 'NTT', 'Perunggu', 'Alat tukar/mahar masyarakat Alor.'],
            ['ART-122', 'Kitab Negarakretagama', 'Majapahit', 'Abad ke-14 M', 'Manuskrip', 'Jawa Timur', 'Daun Lontar', 'Karya sastra Mpu Prapanca.'],
            ['ART-123', 'Rencong Aceh Kuno', 'Kesultanan Aceh', 'Abad ke-16 M', 'Senjata', 'Aceh', 'Besi & Emas', 'Senjata pusaka Kesultanan Aceh.'],
            ['ART-124', 'Prasasti Talang Tuo', 'Sriwijaya', 'Abad ke-7 M', 'Epigrafi', 'Palembang', 'Batu', 'Catatan pembuatan Taman Sriksetra.'],
            ['ART-125', 'Arca Harihara', 'Majapahit', 'Abad ke-13 M', 'Arca', 'Jawa Timur', 'Batu Andesit', 'Gabungan perwujudan Siwa dan Wisnu.'],
            ['ART-126', 'Tombak Kyai Pleret', 'Mataram Islam', 'Abad ke-16 M', 'Senjata', 'Yogyakarta', 'Besi', 'Tombak legendaris Kerajaan Mataram.'],
            ['ART-127', 'Keramik Dinasti Ming', 'Dinasti Ming', 'Abad ke-15 M', 'Keramik', 'Selat Malaka', 'Porselen', 'Bukti perdagangan internasional Nusantara.'],
            ['ART-128', 'Prasasti Mantyasih', 'Mataram Kuno', 'Abad ke-9 M', 'Epigrafi', 'Kedu', 'Tembaga', 'Daftar silsilah raja-raja Sanjaya.'],
            ['ART-129', 'Prasasti Kalasan', 'Mataram Kuno', 'Abad ke-8 M', 'Epigrafi', 'Yogyakarta', 'Batu', 'Pembangunan Candi Kalasan.'],
            ['ART-130', 'Kujang Pajajaran', 'Pajajaran', 'Abad ke-15 M', 'Senjata', 'Jawa Barat', 'Besi Tempa', 'Senjata magis suku Sunda.'],
            ['ART-131', 'Gelang Kaca Kuno', 'Prasejarah', '2000 SM', 'Perhiasan', 'Gilimanuk', 'Kaca', 'Perhiasan kuno masyarakat Bali.'],
            ['ART-132', 'Al-Quran Tulisan Tangan', 'Kesultanan Banten', 'Abad ke-17 M', 'Manuskrip', 'Banten', 'Kertas Kuno', 'Al-Quran berhiaskan iluminasi emas.'],
            ['ART-133', 'Badik Luwu', 'Kerajaan Luwu', 'Abad ke-14 M', 'Senjata', 'Sulawesi Selatan', 'Besi Meteor', 'Senjata kebesaran masyarakat Bugis.'],
            ['ART-134', 'Patung Nias', 'Prasejarah Nias', 'Abad ke-15 M', 'Patung', 'Nias', 'Kayu', 'Patung leluhur masyarakat Nias.'],
            ['ART-135', 'Mahkota Sultan Banten', 'Kesultanan Banten', 'Abad ke-16 M', 'Perhiasan', 'Banten', 'Emas & Permata', 'Mahkota kerajaan peninggalan Sultan.'],
            ['ART-136', 'Prasasti Blanjong', 'Wangsa Warmadewa', 'Abad ke-10 M', 'Epigrafi', 'Bali', 'Batu', 'Dikeluarkan oleh Sri Kesari Warmadewa.']
        ];

        foreach ($data as $idx => $item) {
            Artefak::updateOrCreate(
                ['kode_registrasi' => $item[0]],
                [
                    'nama_artefak' => $item[1],
                    'era_periodisasi' => $item[2],
                    'periode_abad' => $item[3],
                    'kategori' => $item[4],
                    'asal_daerah' => $item[5],
                    'bahan_utama' => $item[6],
                    'deskripsi' => $item[7],
                    'persentase_keutuhan' => rand(70, 100),
                    'bisa_dipinjam' => rand(0, 1) == 1,
                    'gambar_path' => 'https://images.unsplash.com/photo-1544830728-773a4e33645c?auto=format&fit=crop&w=400&q=80'
                ]
            );
        }
    }
}
