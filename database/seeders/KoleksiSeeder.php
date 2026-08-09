<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artefak;
use App\Models\TokohPenting;
use App\Models\ArsipSejarah;
use App\Models\LokasiGeografis;

class KoleksiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ARTEFAK (6 Item Relevan Lhokseumawe / Samudera Pasai)
        Artefak::updateOrCreate(
            ['kode_registrasi' => 'ART-001'],
            [
                'nama_artefak' => 'Dirham Emas Samudera Pasai',
                'nama_lokal' => 'Dirham',
                'era_periodisasi' => 'Kesultanan Samudera Pasai',
                'periode_abad' => 'Abad ke-13 M',
                'kategori' => 'Numismatika',
                'asal_daerah' => 'Aceh Utara / Lhokseumawe',
                'bahan_utama' => 'Emas',
                'deskripsi' => 'Mata uang emas kuno buatan Kesultanan Samudera Pasai. Dirham ini memiliki ukiran kaligrafi Arab nama sultan yang bertakhta, membuktikan kekuatan ekonomi dan kejayaan perdagangan internasional di kawasan Lhokseumawe dan Selat Malaka.',
                'persentase_keutuhan' => 95,
                'bisa_dipinjam' => false,
                'gambar_path' => '/images/koleksi/dirham_pasai_1785137833148.png',
            ]
        );

        Artefak::updateOrCreate(
            ['kode_registrasi' => 'ART-002'],
            [
                'nama_artefak' => 'Cap Sikureueng (Stempel Kesultanan)',
                'nama_lokal' => 'Cap Sembilan',
                'era_periodisasi' => 'Kesultanan Aceh',
                'periode_abad' => 'Abad ke-16 M',
                'kategori' => 'Sigilografi',
                'asal_daerah' => 'Lhokseumawe',
                'bahan_utama' => 'Kuningan & Perunggu',
                'deskripsi' => 'Stempel resmi kerajaan bertata stempel sembilan bundar yang memuat nama sultan yang berkuasa beserta delapan sultan pendahulunya. Digunakan untuk mengesahkan dokumen politik dan perdagangan di Pase.',
                'persentase_keutuhan' => 90,
                'bisa_dipinjam' => true,
                'gambar_path' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
            ]
        );

        Artefak::updateOrCreate(
            ['kode_registrasi' => 'ART-003'],
            [
                'nama_artefak' => 'Rencong Meupukee Kuno',
                'nama_lokal' => 'Rencong Pase',
                'era_periodisasi' => 'Kesultanan Aceh / Pasai',
                'periode_abad' => 'Abad ke-17 M',
                'kategori' => 'Senjata Tradisional',
                'asal_daerah' => 'Lhokseumawe',
                'bahan_utama' => 'Besi Tempa & Tanduk Kerbau',
                'deskripsi' => 'Senjata pusaka khas Aceh dengan sarung bermotifkan pucuk rebung dan ukiran perak halus. Simbol keberanian dan harga diri para pejuang kawasan Lhokseumawe.',
                'persentase_keutuhan' => 88,
                'bisa_dipinjam' => true,
                'gambar_path' => '/images/koleksi/rencong_pase_1785137898183.png',
            ]
        );

        Artefak::updateOrCreate(
            ['kode_registrasi' => 'ART-004'],
            [
                'nama_artefak' => 'Fragmentasi Batu Nisan Marmer Samudera Pasai',
                'nama_lokal' => 'Batu Nisan Pasai',
                'era_periodisasi' => 'Kesultanan Samudera Pasai',
                'periode_abad' => 'Abad ke-15 M',
                'kategori' => 'Epigrafi',
                'asal_daerah' => 'Samudera / Lhokseumawe',
                'bahan_utama' => 'Marmer Gujarat',
                'deskripsi' => 'Potongan batu nisan marmer berkualitas tinggi yang dipahat indah dengan kaligrafi ayat suci Al-Qur\'an dan syair berbahasa Arab. Menandai tingginya seni arsitektur dan hubungan dagang dengan Gujarat.',
                'persentase_keutuhan' => 80,
                'bisa_dipinjam' => false,
                'gambar_path' => 'https://images.unsplash.com/photo-1544830728-773a4e33645c?auto=format&fit=crop&w=800&q=80',
            ]
        );

        Artefak::updateOrCreate(
            ['kode_registrasi' => 'ART-005'],
            [
                'nama_artefak' => 'Meriam Lela Pase',
                'nama_lokal' => 'Lela Perunggu',
                'era_periodisasi' => 'Kesultanan Aceh',
                'periode_abad' => 'Abad ke-16 M',
                'kategori' => 'Artileri Bersejarah',
                'asal_daerah' => 'Lhokseumawe',
                'bahan_utama' => 'Perunggu',
                'deskripsi' => 'Meriam kecil buatan lokal bermotifkan flora dan geometris. Digunakan sebagai pertahanan pesisir benteng pelabuhan Lhokseumawe dari serangan armada asing.',
                'persentase_keutuhan' => 92,
                'bisa_dipinjam' => false,
                'gambar_path' => 'https://images.unsplash.com/photo-1569701812189-7f39487c67bf?auto=format&fit=crop&w=800&q=80',
            ]
        );

        Artefak::updateOrCreate(
            ['kode_registrasi' => 'ART-006'],
            [
                'nama_artefak' => 'Gerabah Kuno Samudera Pasai',
                'nama_lokal' => 'Buyung Tanah Pase',
                'era_periodisasi' => 'Kesultanan Samudera Pasai',
                'periode_abad' => 'Abad ke-14 M',
                'kategori' => 'Keramik & Gerabah',
                'asal_daerah' => 'Lhokseumawe',
                'bahan_utama' => 'Tanah Liat',
                'deskripsi' => 'Wadah penyimpanan air dan minyak yang ditemukan pada situs permukiman kuno pesisir Lhokseumawe. Menunjukkan kehidupan sehari-hari masyarakat abad pertengahan.',
                'persentase_keutuhan' => 75,
                'bisa_dipinjam' => true,
                'gambar_path' => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?auto=format&fit=crop&w=800&q=80',
            ]
        );


        // 2. TOKOH PENTING (6 Tokoh Relevan Lhokseumawe & Pase)
        TokohPenting::updateOrCreate(
            ['nama_tokoh' => 'Sultan Malikussaleh'],
            [
                'nama_julukan' => 'Meurah Silu',
                'gelar' => 'Sultan Pertama Samudera Pasai',
                'peran' => 'Pendiri Kesultanan Samudera Pasai',
                'era_aktif' => 'Akhir Abad ke-13 (1267–1297 M)',
                'tempat_asal' => 'Samudera Pasai',
                'biografi' => 'Pendiri kerajaan Islam pertama di Nusantara (Samudera Pasai) yang mengubah peta peradaban politik dan keagamaan di Asia Tenggara. Kepemimpinannya menjadikan kawasan Lhokseumawe dan Pasai sebagai pusat studi dan perdagangan Islam terkemuka.',
                'kontribusi' => 'Mendirikan Kesultanan Samudera Pasai, menyebarkan Islam di Asia Tenggara, mencetak mata uang dirham emas.',
                'gambar_path' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80',
            ]
        );

        TokohPenting::updateOrCreate(
            ['nama_tokoh' => 'Sultanah Nahrasyiyah'],
            [
                'nama_julukan' => 'Ratu Pengasih dari Pasai',
                'gelar' => 'Sultanah / Ratu Samudera Pasai',
                'peran' => 'Pemimpin Wanita Kesultanan Samudera Pasai',
                'era_aktif' => 'Abad ke-15 (1406–1428 M)',
                'tempat_asal' => 'Samudera Pasai',
                'biografi' => 'Ratu bijaksana yang membawa Kesultanan Samudera Pasai mencapai puncak kejayaan ekonomi, kedamaian sosial, dan hubungan luar negeri yang harmonis dengan Kekaisaran Tiongkok pada masa ekspedisi Cheng Ho.',
                'kontribusi' => 'Memajukan perdagangan laut, mengayomi rakyat dengan sistem berkeadilan, memperkuat posisi diplomatik Kerajaan Pasai.',
                'gambar_path' => '/images/koleksi/sultanah_nahrasyiyah_1785137910946.png',
            ]
        );

        TokohPenting::updateOrCreate(
            ['nama_tokoh' => 'Teungku Chik di Tunong'],
            [
                'nama_julukan' => 'Singa Pejuang Pase',
                'gelar' => 'Pahlawan Kemerdekaan Lokal',
                'peran' => 'Panglima Perang Gerilya Melawan Belanda',
                'era_aktif' => 'Akhir Abad ke-19 (1890–1905 M)',
                'tempat_asal' => 'Keureuto / Lhokseumawe',
                'biografi' => 'Suami dari pahlawan nasional Cut Meutia yang memimpin perlawanan gerilya sengit terhadap pasukan kolonial Belanda di hutan dan pesisir wilayah Lhokseumawe dan Aceh Utara.',
                'kontribusi' => 'Memimpin taktik perang gerilya di Pase dan mengkoordinasikan benteng perlawanan rakyat Lhokseumawe.',
                'gambar_path' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=800&q=80',
            ]
        );

        TokohPenting::updateOrCreate(
            ['nama_tokoh' => 'Cut Meutia'],
            [
                'nama_julukan' => 'Srikandi Pase',
                'gelar' => 'Pahlawan Nasional Indonesia',
                'peran' => 'Pejuang Kemerdekaan Wanita',
                'era_aktif' => 'Awal Abad ke-20 (1870–1910 M)',
                'tempat_asal' => 'Keureuto, Lhokseumawe',
                'biografi' => 'Pahlawan nasional wanita Indonesia kelahiran wilayah Pase (Lhokseumawe). Beliau secara gigih melanjutkan taktik perang gerilya melawan pasukan penjajah Belanda tanpa kenal menyerah.',
                'kontribusi' => 'Memimpin pasukan gerilya Pasai pasca gugurnya Teungku Chik di Tunong hingga akhir hayatnya.',
                'gambar_path' => '/images/koleksi/cut_meutia_1785137847887.png',
            ]
        );

        TokohPenting::updateOrCreate(
            ['nama_tokoh' => 'Laksamana Keumalahayati'],
            [
                'nama_julukan' => 'Laksamana Wanita Pertama Dunia',
                'gelar' => 'Pahlawan Nasional Indonesia',
                'peran' => 'Panglima Armada Laut Kesultanan',
                'era_aktif' => 'Akhir Abad ke-16 (1550–1615 M)',
                'tempat_asal' => 'Aceh / Wilayah Pesisir Pase',
                'biografi' => 'Laksamana wanita pertama dalam sejarah modern yang memimpin armada laut bernama Inong Balee. Bertanggung jawab menjaga keamanan jalur maritim Selat Malaka serta pesisir Lhokseumawe dari armada asing.',
                'kontribusi' => 'Mendirikan benteng laut, memimpin diplomasi serta pertempuran laut mengalahkan penjajah Barat.',
                'gambar_path' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80',
            ]
        );

        TokohPenting::updateOrCreate(
            ['nama_tokoh' => 'Sultan Zainal Abidin III'],
            [
                'nama_julukan' => 'Sultan Diplomat Pasai',
                'gelar' => 'Sultan Samudera Pasai',
                'peran' => 'Penguat Diplomasi Internasional Pasai',
                'era_aktif' => 'Abad ke-14 Masehi',
                'tempat_asal' => 'Samudera Pasai',
                'biografi' => 'Penguasa Samudera Pasai yang gigih memperkuat jaringan persaudaraan dan perdagangan antarnegara di Asia dan Timur Tengah, menjadikan Pasai bandar pelabuhan kosmopolitan.',
                'kontribusi' => 'Mengembangkan sistem pelabuhan terbuka dan menjamin keamanan pedagang asing di Samudera Pasai.',
                'gambar_path' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=800&q=80',
            ]
        );


        // 3. ARSIP SEJARAH (6 Arsip Relevan Lhokseumawe)
        ArsipSejarah::firstOrCreate(
            ['kode_arsip' => 'ARS-001'],
            [
                'judul_arsip' => 'Peta Navigasi Portugis Selat Malaka & Pasai',
                'jenis_koleksi' => 'Peta Kuno',
                'tahun_dokumen' => '1512',
                'bahasa' => 'Portugis / Latin',
                'asal_instansi' => 'Arsip Maritim Lisabon (Salinan)',
                'deskripsi_isi' => 'Peta navigasi kuno kartografer Portugis yang menggambarkan garis pantai Lhokseumawe dan pelabuhan Samudera Pasai sebagai lokasi perhentian dan perdagangan rempah-rempah utama.',
                'kondisi_fisik' => 'Terkonservasi Baik',
                'lokasi_penyimpanan' => 'Ruang Koleksi Khusus Peta',
                'tersedia_publik' => true,
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=800&q=80',
            ]
        );

        ArsipSejarah::firstOrCreate(
            ['kode_arsip' => 'ARS-002'],
            [
                'judul_arsip' => 'Surat Diplomatik Sultan Aceh untuk Gubernur Kolonial',
                'jenis_koleksi' => 'Surat / Dokumen Resmi',
                'tahun_dokumen' => '1873',
                'bahasa' => 'Melayu Jawi (Arab-Melayu)',
                'asal_instansi' => 'Arsip Daerah Lhokseumawe',
                'deskripsi_isi' => 'Dokumen diplomatik bertinta emas menegaskan kedaulatan independen wilayah Lhokseumawe dan pesisir utara Aceh atas klaim kekuasaan pihak asing.',
                'kondisi_fisik' => 'Rapuh, Dalam Enkapsulasi Glass',
                'lokasi_penyimpanan' => 'Brankas Naskah Kuno',
                'tersedia_publik' => true,
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=800&q=80',
            ]
        );

        ArsipSejarah::firstOrCreate(
            ['kode_arsip' => 'ARS-003'],
            [
                'judul_arsip' => 'Manuskrip Hikayat Raja-Raja Pasai',
                'jenis_koleksi' => 'Naskah Kuno',
                'tahun_dokumen' => 'Abad ke-14 M (Salinan 1797)',
                'bahasa' => 'Melayu Klasik Jawi',
                'asal_instansi' => 'Museum E-RTIFACT Lhokseumawe',
                'deskripsi_isi' => 'Manuskrip naskah kuno sastra sejarah pertama di Nusantara yang menceritakan silsilah raja-raja Samudera Pasai, pendirian kota, dan tradisi kehidupan masyarakat Pase.',
                'kondisi_fisik' => 'Terkonservasi Digital',
                'lokasi_penyimpanan' => 'Etalase Naskah Lembaran',
                'tersedia_publik' => true,
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1461360370896-922624d12aa1?auto=format&fit=crop&w=800&q=80',
            ]
        );

        ArsipSejarah::firstOrCreate(
            ['kode_arsip' => 'ARS-004'],
            [
                'judul_arsip' => 'Catatan Perjalanan Ibnu Battuta di Samudera Pasai',
                'jenis_koleksi' => 'Naskah Kuno',
                'tahun_dokumen' => '1345 M',
                'bahasa' => 'Arab',
                'asal_instansi' => 'Perpustakaan Kuno (Manuskrip Digital)',
                'deskripsi_isi' => 'Catatan jurnal pengembara dunia Ibnu Battuta saat singgah di Kesultanan Samudera Pasai. Beliau mengagumi keramahan sultan, sistem peradilan agama, dan fasilitas pelabuhan dagang Pasai.',
                'kondisi_fisik' => 'Digitalisasi HD',
                'lokasi_penyimpanan' => 'Server Repositori Museum',
                'tersedia_publik' => true,
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=800&q=80',
            ]
        );

        ArsipSejarah::firstOrCreate(
            ['kode_arsip' => 'ARS-005'],
            [
                'judul_arsip' => 'Catatan Ekspedisi Armada Laksamana Cheng Ho',
                'jenis_koleksi' => 'Laporan Arkeologi',
                'tahun_dokumen' => '1414 M',
                'bahasa' => 'Tionghoa Klasik',
                'asal_instansi' => 'Arsip Ekspedisi Ming (Faksimil)',
                'deskripsi_isi' => 'Laporan tertulis rombongan pelaut Tiongkok Laksamana Cheng Ho mengenai kunjungan kenegaraan ke Samudera Pasai dan interaksi budaya masyarakat pesisir Lhokseumawe.',
                'kondisi_fisik' => 'Sangat Baik',
                'lokasi_penyimpanan' => 'Galeri Diorama Hubungan Internasional',
                'tersedia_publik' => true,
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
            ]
        );

        ArsipSejarah::firstOrCreate(
            ['kode_arsip' => 'ARS-006'],
            [
                'judul_arsip' => 'Peta Topografi Pelabuhan & Kota Lhokseumawe (1910)',
                'jenis_koleksi' => 'Peta Kuno',
                'tahun_dokumen' => '1910',
                'bahasa' => 'Belanda',
                'asal_instansi' => 'Dinas Kearsipan Daerah',
                'deskripsi_isi' => 'Peta pemetaan tata kota dan jalur kereta api kuno di Lhokseumawe yang dibuat oleh pemerintah kolonial pada awal abad ke-20.',
                'kondisi_fisik' => 'Baik',
                'lokasi_penyimpanan' => 'Arsip Koleksi Pemetaan',
                'tersedia_publik' => true,
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1569336415962-a4bd9f69cd83?auto=format&fit=crop&w=800&q=80',
            ]
        );


        // 4. LOKASI GEOGRAFIS (6 Lokasi Bersejarah Lhokseumawe)
        LokasiGeografis::firstOrCreate(
            ['nama_lokasi' => 'Bukit Gua Jepang Lhokseumawe'],
            [
                'jenis_lokasi' => 'Cagar Budaya',
                'kecamatan' => 'Blang Mangat',
                'kabupaten_kota' => 'Lhokseumawe',
                'provinsi' => 'Aceh',
                'latitude' => 5.1472,
                'longitude' => 97.1423,
                'deskripsi' => 'Kompleks peninggalan gua dan bunker buatan bukit militer tentara Jepang pada Perang Dunia II (1942–1945). Menyajikan pemandangan lanskap kota Lhokseumawe dari atas bukit.',
                'periode_sejarah' => 'Perang Dunia II',
                'status_kelola' => 'Aktif Dijaga',
                'pengelola' => 'Dinas Pariwisata Kota Lhokseumawe',
                'jam_operasional' => '08:00 - 18:00 WIB',
                'gambar_path' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80',
            ]
        );

        LokasiGeografis::firstOrCreate(
            ['nama_lokasi' => 'Situs Makam Sultan Malikussaleh'],
            [
                'jenis_lokasi' => 'Makam Bersejarah',
                'kecamatan' => 'Samudera',
                'kabupaten_kota' => 'Aceh Utara (Dekat Lhokseumawe)',
                'provinsi' => 'Aceh',
                'latitude' => 5.1278,
                'longitude' => 97.2153,
                'deskripsi' => 'Kompleks pemakaman bersejarah tempat peristirahatan terakhir pendiri Kesultanan Samudera Pasai. Merupakan destinasi religi dan wisata sejarah utama di pesisir utara Aceh.',
                'periode_sejarah' => 'Kesultanan Samudera Pasai (Abad 13)',
                'status_kelola' => 'Aktif Dijaga',
                'pengelola' => 'Balai Pelestarian Kebudayaan',
                'jam_operasional' => '07:30 - 18:00 WIB',
                'gambar_path' => 'https://images.unsplash.com/photo-1564507592333-c60657eea523?auto=format&fit=crop&w=800&q=80',
            ]
        );

        LokasiGeografis::firstOrCreate(
            ['nama_lokasi' => 'Situs Makam Sultanah Nahrasyiyah'],
            [
                'jenis_lokasi' => 'Makam Bersejarah',
                'kecamatan' => 'Samudera',
                'kabupaten_kota' => 'Aceh Utara',
                'provinsi' => 'Aceh',
                'latitude' => 5.1290,
                'longitude' => 97.2160,
                'deskripsi' => 'Situs nisan makam marmer milik Ratu Samudera Pasai. Terkenal di mancanegara karena ukiran kaligrafi kaligrafi kaligrafi puitis yang amat halus dan bernilai seni tinggi.',
                'periode_sejarah' => 'Kesultanan Samudera Pasai (Abad 15)',
                'status_kelola' => 'Aktif Dijaga',
                'pengelola' => 'Kementerian Kebudayaan & Pemda',
                'jam_operasional' => '08:00 - 17:30 WIB',
                'gambar_path' => 'https://images.unsplash.com/photo-1548625361-185e78342416?auto=format&fit=crop&w=800&q=80',
            ]
        );

        LokasiGeografis::firstOrCreate(
            ['nama_lokasi' => 'Masjid Agung Islamic Center Lhokseumawe'],
            [
                'jenis_lokasi' => 'Masjid Bersejarah',
                'kecamatan' => 'Banda Sakti',
                'kabupaten_kota' => 'Lhokseumawe',
                'provinsi' => 'Aceh',
                'latitude' => 5.1786,
                'longitude' => 97.1481,
                'deskripsi' => 'Masjid megah landmark Kota Lhokseumawe dengan arsitektur menawan perpaduan gaya Timur Tengah dan corak ukiran tradisional Samudera Pasai.',
                'periode_sejarah' => 'Modern Berbasis Historis',
                'status_kelola' => 'Aktif Dijaga',
                'pengelola' => 'Badan Kemakmuran Masjid Islamic Center',
                'jam_operasional' => '24 Jam',
                'gambar_path' => 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?auto=format&fit=crop&w=800&q=80',
            ]
        );

        LokasiGeografis::firstOrCreate(
            ['nama_lokasi' => 'Taman & Waduk Jeulikat Lhokseumawe'],
            [
                'jenis_lokasi' => 'Cagar Budaya',
                'kecamatan' => 'Blang Mangat',
                'kabupaten_kota' => 'Lhokseumawe',
                'provinsi' => 'Aceh',
                'latitude' => 5.1380,
                'longitude' => 97.1550,
                'deskripsi' => 'Kawasan wisata alam dan resapan air bersejarah di Lhokseumawe yang dikelilingi perbukitan hijau dan menjadi tujuan wisata edukasi keluarga.',
                'periode_sejarah' => 'Pariwisata & Konservasi',
                'status_kelola' => 'Aktif Dijaga',
                'pengelola' => 'Pemerintah Kota Lhokseumawe',
                'jam_operasional' => '08:00 - 18:00 WIB',
                'gambar_path' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
            ]
        );

        LokasiGeografis::firstOrCreate(
            ['nama_lokasi' => 'Situs Pelabuhan Kuno Krueng Cunda'],
            [
                'jenis_lokasi' => 'Situs Arkeologi',
                'kecamatan' => 'Muara Dua',
                'kabupaten_kota' => 'Lhokseumawe',
                'provinsi' => 'Aceh',
                'latitude' => 5.1650,
                'longitude' => 97.1400,
                'deskripsi' => 'Kawasan alur perairan sungai bersejarah yang dahulunya merupakan dermaga pelabuhan transit kapal-kapal pedagang Arab, Tiongkok, dan Gujarat di Lhokseumawe.',
                'periode_sejarah' => 'Kesultanan Samudera Pasai',
                'status_kelola' => 'Aktif Dijaga',
                'pengelola' => 'Dinas Kebudayaan & Kelautan',
                'jam_operasional' => '24 Jam',
                'gambar_path' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?auto=format&fit=crop&w=800&q=80',
            ]
        );
    }
}
