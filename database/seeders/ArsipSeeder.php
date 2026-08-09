<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArsipSejarah;

class ArsipSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // I. Naskah Kuno & Kesultanan
            ['ARS-001', 'Surat Sultan Aceh ke Raja James I (1615)', 'Naskah Kuno & Kesultanan', 'Surat diplomatik stempel cap halilintar mengenai hak perdagangan.', 'Bodleian Library, Oxford (MS. Laud Or. e. 4)', 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Letter_to_James_I_from_Sultan_Iskandar_Muda_of_Aceh_in_1615.jpg'],
            ['ARS-002', 'Bustanussalatin (1638)', 'Naskah Kuno & Kesultanan', 'Naskah silsilah raja, hukum tata negara, dan sejarah Kesultanan.', 'Museum Aceh & British Library', 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Letter_to_James_I_from_Sultan_Iskandar_Muda_of_Aceh_in_1615.jpg'],
            ['ARS-003', 'Kanun Meukuta Alam', 'Naskah Kuno & Kesultanan', 'Undang-undang Kesultanan Aceh tentang hukum & perpajakan.', 'Perpustakaan Nasional RI & PDIA', 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Letter_to_James_I_from_Sultan_Iskandar_Muda_of_Aceh_in_1615.jpg'],
            ['ARS-004', 'Surat Perjanjian Aceh-Turki Utsmani', 'Naskah Kuno & Kesultanan', 'Korespondensi bantuan militer abad ke-16.', 'Başbakanlık Osmanlı Arşivi, Istanbul, Turki', 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Letter_to_James_I_from_Sultan_Iskandar_Muda_of_Aceh_in_1615.jpg'],
            ['ARS-005', 'Stempel Cap Sikureueng', 'Naskah Kuno & Kesultanan', 'Stempel sembilan nama raja sebagai validasi dokumen resmi.', 'Dokumen diplomatik abad ke-17 (ANRI & Leiden)', 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Letter_to_James_I_from_Sultan_Iskandar_Muda_of_Aceh_in_1615.jpg'],
            ['ARS-006', 'Hikayat Prang Sabi (1881)', 'Naskah Kuno & Kesultanan', 'Manuskrip sastra & ideologi perlawanan karya Teungku Cik Pante Kulu.', 'Museum Negeri Aceh & Universitas Leiden', 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Letter_to_James_I_from_Sultan_Iskandar_Muda_of_Aceh_in_1615.jpg'],

            // II. Era Kolonial & Perang Aceh
            ['ARS-007', 'Maklumat Perang Belanda (1873)', 'Era Kolonial & Perang Aceh', 'Pernyataan perang resmi oleh F.N. Nieuwenhuijzen (7 April 1873).', 'Nationaal Archief Den Haag & ANRI', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cf/COLLECTIE_TROPENMUSEUM_Atjehse_krijgers_met_vuurwapens_TMnr_60046522.jpg/800px-COLLECTIE_TROPENMUSEUM_Atjehse_krijgers_met_vuurwapens_TMnr_60046522.jpg'],
            ['ARS-008', 'Laporan Snouck Hurgronje (De Atjehers)', 'Era Kolonial & Perang Aceh', 'Berkas rahasia pemetaan sosiologis dan militer (1891-1892).', 'KITLV Leiden & Perpustakaan Leiden', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cf/COLLECTIE_TROPENMUSEUM_Atjehse_krijgers_met_vuurwapens_TMnr_60046522.jpg/800px-COLLECTIE_TROPENMUSEUM_Atjehse_krijgers_met_vuurwapens_TMnr_60046522.jpg'],
            ['ARS-009', 'Peta Topografi Militer Belanda', 'Era Kolonial & Perang Aceh', 'Pemetaan geospasial Kutaraja dan benteng militer (1874-1920).', 'Leiden University Libraries Digital Collections', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cf/COLLECTIE_TROPENMUSEUM_Atjehse_krijgers_met_vuurwapens_TMnr_60046522.jpg/800px-COLLECTIE_TROPENMUSEUM_Atjehse_krijgers_met_vuurwapens_TMnr_60046522.jpg'],
            ['ARS-010', 'Register Tahanan Perang Aceh', 'Era Kolonial & Perang Aceh', 'Daftar pengasingan pejuang Aceh (termasuk Cut Nyak Dhien).', 'Buku Register Tahanan Kolonial di ANRI Jakarta', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cf/COLLECTIE_TROPENMUSEUM_Atjehse_krijgers_met_vuurwapens_TMnr_60046522.jpg/800px-COLLECTIE_TROPENMUSEUM_Atjehse_krijgers_met_vuurwapens_TMnr_60046522.jpg'],

            // III. Era Kemerdekaan
            ['ARS-011', 'Obligasi Pembelian RI-001 Seulawah', 'Era Kemerdekaan', 'Bukti sumbangan emas/uang rakyat Aceh untuk pesawat pertama RI (1948).', 'Gedung ANRI Jakarta & Museum Aceh', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Seulawah_RI-001.jpg/800px-Seulawah_RI-001.jpg'],
            ['ARS-012', 'UU No. 24 Tahun 1956', 'Era Kemerdekaan', 'Penetapan pembentukan kembali Provinsi Aceh sebagai daerah otonom.', 'Lembaran Negara RI Tahun 1956 Nomor 64', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Seulawah_RI-001.jpg/800px-Seulawah_RI-001.jpg'],
            ['ARS-013', 'Ikrar Lamteh (1957)', 'Era Kemerdekaan', 'Deklarasi penyelesaian konflik DI/TII Aceh.', 'Arsip Kodam Iskandar Muda & ANRI', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Seulawah_RI-001.jpg/800px-Seulawah_RI-001.jpg'],

            // IV. Bencana & Rekonstruksi Tsunami
            ['ARS-014', 'Memori Kolektif Tsunami 2004', 'Bencana & Rekonstruksi Tsunami', 'Kumpulan berkas teks, foto, peta, & video penanganan tsunami.', 'UNESCO Memory of the World Register (BAST ANRI)', 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1d/US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg/800px-US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg'],
            ['ARS-015', 'Peta Kerusakan Tsunami (Bakosurtanal)', 'Bencana & Rekonstruksi Tsunami', 'Arsip geospasial zona kehancuran pesisir Aceh.', 'Arsip Kartografi BAST ANRI Banda Aceh', 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1d/US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg/800px-US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg'],
            ['ARS-016', 'Master Plan BRR Aceh-Nias', 'Bencana & Rekonstruksi Tsunami', 'Cetakan biru rekonstruksi fisik & sosial pasca-tsunami (2005-2009).', 'Laporan Akhir BRR di BAST ANRI', 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1d/US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg/800px-US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg'],
            ['ARS-017', 'Arsip DVI Tsunami Aceh', 'Bencana & Rekonstruksi Tsunami', 'Rekam medis dan pencatatan kepolisian identifikasi korban.', 'Polda Aceh & BAST ANRI', 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1d/US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg/800px-US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg'],
            ['ARS-018', 'Audio-Visual Peliputan Tsunami', 'Bencana & Rekonstruksi Tsunami', 'Rekaman siaran mentah detik-detik gempa & tsunami 26 Des 2004.', 'TVRI Aceh, Metro TV, & ANRI', 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1d/US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg/800px-US_Navy_050102-N-5362A-073_A_village_near_the_coast_of_Sumatra_lays_in_ruin_after_the_Tsunami_that_struck_South_East_Asia.jpg'],

            // V. Perdamaian Aceh (MoU Helsinki)
            ['ARS-019', 'Naskah Perjanjian Damai MoU Helsinki', 'Perdamaian Aceh', 'Kesepakatan damai RI - GAM di Finland (15 Agustus 2005).', 'Kemenlu RI & Kemenko Polhukam', 'https://upload.wikimedia.org/wikipedia/commons/f/ff/Perjanjian_damai_helsinki.jpg'],
            ['ARS-020', 'UU No. 11 Tahun 2006 (UUPA)', 'Perdamaian Aceh', 'Payung hukum otonomi khusus Aceh konversi MoU Helsinki.', 'Lembaran Negara RI Tahun 2006 Nomor 62', 'https://upload.wikimedia.org/wikipedia/commons/f/ff/Perjanjian_damai_helsinki.jpg'],
            ['ARS-021', 'Laporan Monitoring AMM (2005-2006)', 'Perdamaian Aceh', 'Laporan verifikasi pemusnahan senjata GAM & penarikan pasukan.', 'EU External Action Archive & BAST ANRI', 'https://upload.wikimedia.org/wikipedia/commons/f/ff/Perjanjian_damai_helsinki.jpg'],
            ['ARS-022', 'Berita Acara Pemusnahan Senjata GAM', 'Perdamaian Aceh', 'Dokumentasi penyerahan & pemusnahan senjata di bawah AMM.', 'Foto, Video, & Berita Acara di BAST ANRI', 'https://upload.wikimedia.org/wikipedia/commons/f/ff/Perjanjian_damai_helsinki.jpg'],

            // VI. Kelembagaan, Tata Kelola & Adat
            ['ARS-023', 'SK Pembentukan DPKA', 'Kelembagaan, Tata Kelola & Adat', 'Landasan pendirian Dinas Perpustakaan dan Kearsipan Aceh.', 'Qanun Aceh No. 39 Tahun 2001', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Tari_Saman_Gayo.jpg/800px-Tari_Saman_Gayo.jpg'],
            ['ARS-024', 'Qanun Aceh No. 12 Tahun 2014', 'Kelembagaan, Tata Kelola & Adat', 'Regulasi tata kelola, preservasi, dan pengawasan kearsipan Aceh.', 'Lembaran Daerah Aceh Tahun 2014 Nomor 12', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Tari_Saman_Gayo.jpg/800px-Tari_Saman_Gayo.jpg'],
            ['ARS-025', 'Naskah Majelis Adat Aceh (MAA)', 'Kelembagaan, Tata Kelola & Adat', 'Kodifikasi aturan hukum adat (Panglima Laot, Adat Meulayeue).', 'Inventarisasi Arsip Majelis Adat Aceh', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Tari_Saman_Gayo.jpg/800px-Tari_Saman_Gayo.jpg'],
            ['ARS-026', 'Penetapan WBTb Aceh', 'Kelembagaan, Tata Kelola & Adat', 'Berkas pengusulan warisan budaya (Saman, Ranup Lam Puan, Pinto Aceh).', 'Sertifikat WBTb Kemendikbudristek RI', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Tari_Saman_Gayo.jpg/800px-Tari_Saman_Gayo.jpg'],
            ['ARS-027', 'Digitalisasi Manuskrip Kuno Aceh', 'Kelembagaan, Tata Kelola & Adat', 'Database alih media manuskrip Arab-Melayu (Jawoe).', 'Repository DPKA & UIN Ar-Raniry', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Tari_Saman_Gayo.jpg/800px-Tari_Saman_Gayo.jpg'],
            ['ARS-028', 'Register Tanah Wakaf Masjid Raya', 'Kelembagaan, Tata Kelola & Adat', 'Arsip pertanahan dan batas wilayah wakaf Masjid Raya Baiturrahman.', 'BPN Aceh & Pengurus Masjid Raya', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Tari_Saman_Gayo.jpg/800px-Tari_Saman_Gayo.jpg'],
            ['ARS-029', 'SK Pahlawan Nasional Tokoh Aceh', 'Kelembagaan, Tata Kelola & Adat', 'Berkas penetapan pahlawan (Malahayati, Iskandar Muda, Teuku Umar, dll).', 'Keppres RI di Kementerian Sosial & ANRI', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Tari_Saman_Gayo.jpg/800px-Tari_Saman_Gayo.jpg'],
            ['ARS-030', 'Sertifikat UNESCO Tari Saman (2011)', 'Kelembagaan, Tata Kelola & Adat', 'Pengakuan Tari Saman sebagai Intangible Cultural Heritage.', 'Sertifikat Resmi UNESCO (24 Nov 2011)', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Tari_Saman_Gayo.jpg/800px-Tari_Saman_Gayo.jpg'],
        ];

        foreach ($data as $item) {
            ArsipSejarah::updateOrCreate(
                ['kode_arsip' => $item[0]],
                [
                    'judul_arsip' => $item[1],
                    'jenis_koleksi' => $item[2],
                    'tahun_dokumen' => 'N/A',
                    'bahasa' => 'Campuran',
                    'asal_instansi' => 'Arsip Aceh',
                    'deskripsi_isi' => $item[3],
                    'kondisi_fisik' => 'Beragam',
                    'lokasi_penyimpanan' => $item[4],
                    'tersedia_publik' => true,
                    'gambar_thumbnail' => $item[5]
                ]
            );
        }
    }
}
